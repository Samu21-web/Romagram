<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use AfricasTalking\SDK\AfricasTalking;

class ForgotPasswordController extends Controller
{
    // Step 1: user submits email, we email + SMS a 6-digit code
    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email address.'], 'resetPassword')
                ->with('reset_step', 'email');
        }

        $code = random_int(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => Hash::make($code), 'created_at' => now()]
        );

        // Send email
        Mail::send('emails.reset-code', ['code' => $code], function ($message) use ($request) {
            $message->to($request->email)->subject('Your Romagram Password Reset Code');
        });

        // Send SMS if user has a phone number on file
        if ($user->phone) {
            $this->sendSms($user->phone, "Your Romagram password reset code is: {$code}. This code expires in 15 minutes.");
        }

        return back()->with('reset_step', 'code')->with('reset_email', $request->email);
    }

    // Step 2: user submits the code
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->code, $record->token)) {
            return back()->withErrors(['code' => 'Invalid or expired code.'], 'resetPassword')
                ->with('reset_step', 'code')->with('reset_email', $request->email);
        }

        if (now()->diffInMinutes($record->created_at) > 15) {
            return back()->withErrors(['code' => 'This code has expired. Please request a new one.'], 'resetPassword')
                ->with('reset_step', 'email');
        }

        return back()->with('reset_step', 'password')
            ->with('reset_email', $request->email)
            ->with('reset_code', $request->code);
    }

    // Step 3: user sets new password
    public function reset(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'code'     => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->code, $record->token)) {
            return back()->withErrors(['code' => 'Invalid or expired code.'], 'resetPassword')->with('reset_step', 'email');
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found.'], 'resetPassword')->with('reset_step', 'email');
        }

        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/')->with('reset_success', true);
    }

    // Helper: send SMS via Africa's Talking
    private function sendSms(string $phone, string $message): void
    {
        try {
            $AT = new AfricasTalking(config('services.africastalking.username'), config('services.africastalking.api_key'));
            $sms = $AT->sms();
            $sms->send([
                'to'      => $phone,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            \Log::error('Africa\'s Talking SMS failed: ' . $e->getMessage());
        }
    }
}