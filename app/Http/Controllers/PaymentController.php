<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->get();
        return view('pricing', compact('packages'));
    }

    // Redirect to Paystack
    public function initiate(Request $request)
    {
        $request->validate(['package_id' => 'required|exists:packages,id']);

        $package   = Package::findOrFail($request->package_id);
        $user      = auth()->user();
        $reference = 'ROMP_' . strtoupper(Str::random(10)) . '_' . time();

        Payment::create([
            'user_id'    => $user->id,
            'package_id' => $package->id,
            'amount'     => $package->price,
            'reference'  => $reference,
            'status'     => 'pending',
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode([
                'email'        => $user->email,
                'amount'       => $package->price * 100,
                'currency'     => 'KES',
                'reference'    => $reference,
                'callback_url' => route('payment.callback'),
                'metadata'     => [
                    'user_id'    => $user->id,
                    'package_id' => $package->id,
                    'custom_fields' => [
                        ['display_name' => 'Customer Name', 'variable_name' => 'customer_name', 'value' => $user->name],
                        ['display_name' => 'Package', 'variable_name' => 'package', 'value' => $package->name],
                    ]
                ],
            ]),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . config('services.paystack.secret_key'),
                "Content-Type: application/json",
            ],
        ]);

        $raw = curl_exec($curl);
        $curlError = curl_error($curl);
        curl_close($curl);

        $response = json_decode($raw, true);

        if ($raw === false || !is_array($response)) {
            Log::error('Paystack initiate failed', ['curl_error' => $curlError, 'raw' => $raw]);
            return back()->with('error', 'Could not reach payment provider. Please try again.');
        }

        if (!empty($response['status'])) {
            return redirect($response['data']['authorization_url']);
        }

        Log::error('Paystack initiate rejected', ['response' => $response]);
        return back()->with('error', 'Could not initiate payment. Please try again.');
    }

    // Paystack redirects here after payment (browser-facing)
    public function callback(Request $request)
    {
        $reference = $request->reference;
        $payment   = Payment::where('reference', $reference)->firstOrFail();

        // Idempotency guard — already processed, don't re-extend expiry
        if ($payment->status === 'completed') {
            return redirect()->route('discover')
                ->with('success', 'Payment already confirmed. You are Premium!');
        }

        $verified = $this->verifyWithPaystack($reference);

        if ($verified === null) {
            return redirect()->route('pricing')
                ->with('error', 'Could not verify payment right now. If you were charged, contact support with reference ' . $reference);
        }

        if ($verified['status'] && $verified['data']['status'] === 'success') {
            $this->markPaymentCompleted($payment, $verified);

            return redirect()->route('discover')
                ->with('success', '🎉 Payment successful! You are now a Premium member!');
        }

        $payment->update(['status' => 'failed']);
        return redirect()->route('pricing')
            ->with('error', 'Payment failed or was cancelled. Please try again.');
    }

    // Paystack calls this server-to-server, independent of the user's browser
    public function webhook(Request $request)
    {
        $signature = $request->header('x-paystack-signature');
        $secret    = config('services.paystack.secret_key');
        $payload   = $request->getContent();

        $expected = hash_hmac('sha512', $payload, $secret);

        if (!$signature || !hash_equals($expected, $signature)) {
            Log::warning('Paystack webhook signature mismatch');
            return response()->json(['status' => 'invalid signature'], 401);
        }

        $event = json_decode($payload, true);

        if (($event['event'] ?? null) === 'charge.success') {
            $reference = $event['data']['reference'] ?? null;
            $payment   = Payment::where('reference', $reference)->first();

            if ($payment && $payment->status !== 'completed') {
                $verified = $this->verifyWithPaystack($reference);

                if ($verified && $verified['status'] && $verified['data']['status'] === 'success') {
                    $this->markPaymentCompleted($payment, $verified);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }

    private function verifyWithPaystack(string $reference): ?array
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.paystack.co/transaction/verify/{$reference}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer " . config('services.paystack.secret_key'),
                "Content-Type: application/json",
            ],
        ]);

        $raw = curl_exec($curl);
        $curlError = curl_error($curl);
        curl_close($curl);

        $response = json_decode($raw, true);

        if ($raw === false || !is_array($response)) {
            Log::error('Paystack verify failed', ['reference' => $reference, 'curl_error' => $curlError]);
            return null;
        }

        return $response;
    }

    private function markPaymentCompleted(Payment $payment, array $verified): void
    {
        $payment->update([
            'status'             => 'completed',
            'paystack_reference' => $verified['data']['reference'],
            'expires_at'         => now()->addDays($payment->package->duration_days),
        ]);

        $payment->user->update([
            'subscription_plan' => 'premium',
        ]);
    }
}