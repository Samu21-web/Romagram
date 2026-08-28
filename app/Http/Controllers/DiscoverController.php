<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Swipe;
use App\Models\Favourite;
use Illuminate\Http\Request;

class DiscoverController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getProfiles($request, 1);

        return view('discover', [
            'profiles'     => $data['profiles'],
            'isPremium'    => $data['isPremium'],
            'favouriteIds' => $data['favouriteIds'],
            'hasMore'      => $data['hasMore'],
            'currentPage'  => 1,
        ]);
    }

    public function loadMore(Request $request)
    {
        $page = (int) $request->get('page', 2);
        if ($page < 2) $page = 2;

        $data = $this->getProfiles($request, $page);

        $html = '';
        foreach ($data['profiles'] as $profile) {
            $isLocked = !$data['isPremium'];

            $html .= view('partials.discover-card', [
                'profile'      => $profile,
                'isLocked'     => $isLocked,
                'favouriteIds' => $data['favouriteIds'],
            ])->render();
        }

        return response()->json([
            'html'    => $html,
            'hasMore' => $data['hasMore'],
        ]);
    }

    private function resolvePerPage(Request $request): int
    {
        $userAgent = $request->userAgent() ?? '';

        $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod/i', $userAgent);

        return $isMobile ? 16 : 15;
    }

    private function getProfiles(Request $request, int $page): array
    {
        $user      = auth()->user();
        $isPremium = in_array($user->subscription_plan, ['premium', 'gold']);
        $perPage   = $this->resolvePerPage($request);

        $passedIds = Swipe::where('swiper_id', $user->id)
            ->where('action', 'pass')
            ->pluck('swiped_id')
            ->toArray();

        $excludeIds = array_merge([$user->id], $passedIds);

        $hasLocation = !is_null($user->latitude) && !is_null($user->longitude);

        $baseQuery = function () use ($excludeIds, $request, $user, $hasLocation) {
            $q = User::whereNotIn('id', $excludeIds)
                      ->where('profile_complete', true)
                      ->where('is_deactivated', false);

if ($request->gender) {
    $q->where('gender', $request->gender);
} elseif ($user->interested_in !== 'any') {
    $q->where('gender', $user->interested_in);
}

            if ($request->min_age) $q->where('age', '>=', (int) $request->min_age);
            if ($request->max_age) $q->where('age', '<=', (int) $request->max_age);
            if ($request->city)    $q->where('city', 'like', '%' . $request->city . '%');

            if ($request->search) {
                $term = $request->search;
                $q->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', '%' . $term . '%')
                        ->orWhere('city', 'like', '%' . $term . '%')
                        ->orWhere('country', 'like', '%' . $term . '%');
                });
            }

            if ($hasLocation) {
                $q->selectRaw(
                    'users.*, (
                        6371 * acos(
                            cos(radians(?)) * cos(radians(latitude)) *
                            cos(radians(longitude) - radians(?)) +
                            sin(radians(?)) * sin(radians(latitude))
                        )
                    ) AS distance',
                    [$user->latitude, $user->longitude, $user->latitude]
                );
                $q->orderByRaw('distance IS NULL, distance ASC');
            } else {
                $q->orderByDesc('created_at');
            }

            return $q;
        };

        $favouriteIds = Favourite::where('user_id', $user->id)
            ->pluck('favourite_id')
            ->toArray();

        if ($isPremium) {
            $profiles = $baseQuery()
                ->skip(($page - 1) * $perPage)
                ->take($perPage)
                ->get();

            $totalCount = $baseQuery()->count();
            $hasMore    = ($page * $perPage) < $totalCount;

            return compact('profiles', 'isPremium', 'favouriteIds', 'hasMore');
        }

        if ($page === 1) {
            $featuredProfile = $baseQuery()->where('is_featured', true)
                ->orderByRaw('RAND()')
                ->first();

            $restQuery = $baseQuery();
            if ($featuredProfile) {
                $restQuery->where('id', '!=', $featuredProfile->id);
            }
            $restLimit    = $featuredProfile ? $perPage - 1 : $perPage;
            $restProfiles = $restQuery->take($restLimit)->get();

            $profiles = $featuredProfile
                ? collect([$featuredProfile])->concat($restProfiles)
                : $restProfiles;

            $totalCount = $baseQuery()->count();
            $hasMore    = $totalCount > $perPage;

            return compact('profiles', 'isPremium', 'favouriteIds', 'hasMore');
        }

        $profiles = $baseQuery()
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        $totalCount = $baseQuery()->count();
        $hasMore    = ($page * $perPage) < $totalCount;

        return compact('profiles', 'isPremium', 'favouriteIds', 'hasMore');
    }

    public function swipe(Request $request)
    {
        $request->validate([
            'swiped_id' => 'required|exists:users,id',
            'action'    => 'required|in:like,pass,super_like',
        ]);

        $swiper = auth()->user();

        Swipe::updateOrCreate(
            ['swiper_id' => $swiper->id, 'swiped_id' => $request->swiped_id],
            ['action' => $request->action]
        );

        $match = null;
        if ($request->action !== 'pass') {
            $mutual = Swipe::where('swiper_id', $request->swiped_id)
                ->where('swiped_id', $swiper->id)
                ->whereIn('action', ['like', 'super_like'])
                ->first();

            if ($mutual) {
                $match = User::find($request->swiped_id);
            }
        }

        return response()->json([
            'success' => true,
            'match'   => $match ? [
                'name'   => $match->name,
                'avatar' => $match->avatar ? asset('storage/' . $match->avatar) : null,
            ] : null,
        ]);
    }
}