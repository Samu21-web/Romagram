<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Swipe;

class MatchController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get IDs of people I liked
        $iLiked = Swipe::where('swiper_id', $user->id)
            ->whereIn('action', ['like', 'super_like'])
            ->pluck('swiped_id')
            ->toArray();

        // Get IDs of people who liked me
        $likedMe = Swipe::whereIn('swiper_id', $iLiked)
            ->where('swiped_id', $user->id)
            ->whereIn('action', ['like', 'super_like'])
            ->pluck('swiper_id')
            ->toArray();

        // Mutual = intersection
        $matchIds = array_intersect($iLiked, $likedMe);

        $matches = [];
        foreach ($matchIds as $matchId) {
            $profile = User::find($matchId);
            if (!$profile) continue;

            // Get when the match happened (when they liked me back)
            $matchedAt = Swipe::where('swiper_id', $matchId)
                ->where('swiped_id', $user->id)
                ->whereIn('action', ['like', 'super_like'])
                ->first()
                ->created_at;

            $matches[] = [
                'profile'   => $profile,
                'matchedAt' => $matchedAt,
                'isNew'     => $matchedAt->diffInHours(now()) < 24,
            ];
        }

        // Sort by most recent match first
        usort($matches, fn($a, $b) =>
            $b['matchedAt'] <=> $a['matchedAt']
        );

        $newCount   = count(array_filter($matches, fn($m) => $m['isNew']));
        $totalCount = count($matches);

        return view('matches', compact('matches', 'newCount', 'totalCount'));
    }
}