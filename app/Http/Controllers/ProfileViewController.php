<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Favourite;

class ProfileViewController extends Controller
{
    public function show($id)
    {
        $profile = User::findOrFail($id);
        $authUser = auth()->user();
        $isPremium = $authUser->subscription_plan === 'premium' || $authUser->subscription_plan === 'gold';

        $isFavourited = Favourite::where('user_id', $authUser->id)
            ->where('favourite_id', $id)
            ->exists();

        return view('profile-view', compact('profile', 'isPremium', 'isFavourited'));
    }
}