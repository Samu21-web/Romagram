<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Register ──
    public function register(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|min:2|max:30',
            'email'            => 'required|email|unique:users,email',
            'phone'            => 'required|unique:users,phone',
            'password'         => 'required|min:8|confirmed',
            'gender'           => 'required|in:male,female',
            'interested_in' => 'required|in:male,female,any',
            'age'              => 'required|integer|min:18|max:80',
        ]);

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'password'      => Hash::make($request->password),
            'gender'        => $request->gender,
            'interested_in' => $request->interested_in,
            'age'           => $request->age,
        ]);

        Auth::login($user);

        return redirect()->route('setup.location');
    }

    // ── Login ──
    public function login(Request $request)
    {
        $request->validate([
            'phone'    => 'required',
            'password' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return back()->withErrors([
                'phone' => 'No account found with this phone number.'
            ])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'phone' => 'Incorrect password. Please try again.'
            ])->withInput();
        }

        if ($user->is_deactivated) {
            return back()->withErrors([
                'phone' => 'Your account is deactivated. You cannot login. Please contact support.'
            ])->withInput();
        }

        Auth::login($user);

        return redirect()->route('discover');
    }

    // ── Logout ──
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ── Location setup page ──
    public function locationSetup()
    {
        return view('setup.location');
    }

    // ── Save location ──
    public function saveLocation(Request $request)
    {
        auth()->user()->update([
            'latitude'  => $request->latitude ?? null,
            'longitude' => $request->longitude ?? null,
            'city'      => $request->city ?? null,
            'country'   => $request->country ?? null,
        ]);

        return redirect()->route('setup.photos');
    }

    // ── Photo setup page ──
    public function photoSetup()
    {
        return view('setup.photos');
    }

    // ── Save photos ──
    public function savePhotos(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $path = $request->file('avatar')->store('avatars', 'public');

        auth()->user()->update([
            'avatar'           => $path,
            'profile_complete' => true,
        ]);

        return redirect()->route('discover');
    }
}