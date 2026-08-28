<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user()->load('photos');
        return view('my-profile', compact('user'));
    }

public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name'   => 'required|string|min:2|max:30',
        'email'  => 'required|email|unique:users,email,' . $user->id,
        'phone'  => 'required|unique:users,phone,' . $user->id,
        'city'   => 'nullable|string',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
    ]);

    $data = [
        'name'  => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'city'  => $request->city,
    ];

    if ($request->hasFile('avatar')) {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    $user->update($data);

    return back()->with('success', 'Profile updated successfully!');
}

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully!');
    }

    public function uploadPhotos(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'photos'   => 'required|array|max:5',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $existingCount = $user->photos()->count();
        $incomingCount = count($request->file('photos'));

        if ($existingCount + $incomingCount > 5) {
            return back()->withErrors(['photos' => 'You can only have up to 5 extra photos. You currently have ' . $existingCount . '.']);
        }

        $nextPosition = $existingCount;

        foreach ($request->file('photos') as $file) {
            $path = $file->store('photos', 'public');

            Photo::create([
                'user_id'  => $user->id,
                'path'     => $path,
                'position' => $nextPosition,
            ]);

            $nextPosition++;
        }

        return back()->with('success', 'Photos uploaded successfully!');
    }

    public function deletePhoto($id)
    {
        $photo = Photo::findOrFail($id);

        if ($photo->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return response()->json(['success' => true]);
    }

    public function deactivate()
    {
        $user = auth()->user();
        $user->update([
            'deactivated_at' => now(),
            'is_deactivated' => true,
        ]);
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/')->with('success', 'Your account has been deactivated. We hope to see you again!');
    }
}