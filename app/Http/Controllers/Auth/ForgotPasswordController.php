<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Step 1: user submits email, we email a 6-digit code
    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email address.'])
                ->with('reset_step', 'email');
        }

        $code = random_int(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => Hash::make($code), 'created_at' => now()]
        );

        Mail::raw("Your Romagram password reset code is: {$code}\n\nThis code expires in 15 minutes.", function ($message) use ($request) {
            $message->to($request->email)->subject('Your Romagram Password Reset Code');
        });

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
            return back()->withErrors(['code' => 'Invalid or expired code.'])
                ->with('reset_step', 'code')->with('reset_email', $request->email);
        }

        if (now()->diffInMinutes($record->created_at) > 15) {
            return back()->withErrors(['code' => 'This code has expired. Please request a new one.'])
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
            return back()->withErrors(['code' => 'Invalid or expired code.'])->with('reset_step', 'email');
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found.'])->with('reset_step', 'email');
        }

        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/')->with('reset_success', true);
    }
}