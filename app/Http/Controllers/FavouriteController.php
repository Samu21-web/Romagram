<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function index()
{
    $favourites = \App\Models\Favourite::where('user_id', auth()->id())
        ->with('favourite')
        ->latest()
        ->get()
        ->pluck('favourite');

    return view('favourites', compact('favourites'));
}
    public function toggle($id)
    {
        $userId = auth()->id();

        $existing = Favourite::where('user_id', $userId)
            ->where('favourite_id', $id)
            ->first();

        if ($existing) {
            $existing->delete();
            $favourited = false;
        } else {
            Favourite::create([
                'user_id'      => $userId,
                'favourite_id' => $id,
            ]);
            $favourited = true;
        }

        return response()->json(['favourited' => $favourited]);
    }
}