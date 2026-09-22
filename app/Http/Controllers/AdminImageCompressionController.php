<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Photo;
use App\Services\ImageCompressionService;
use Illuminate\Http\Request;

class AdminImageCompressionController extends Controller
{
    /**
     * How many avatars + extra photos still need compressing.
     * Used by the modal to size the progress bar before starting.
     */
    public function pendingCount()
    {
        $total = User::whereNotNull('avatar')
                ->where('avatar', 'not like', '%.webp')
                ->count()
            + Photo::where('path', 'not like', '%.webp')->count();

        return response()->json(['total' => $total]);
    }

    /**
     * Compress one batch (default 10) of not-yet-webp avatars/photos.
     * Called repeatedly by the modal's JS until "remaining" is 0.
     *
     * Any image that fails to compress is reported back with an id AND
     * a human-readable reason (from ImageCompressionService), so failures
     * are diagnosable instead of a silent count. Failed ids are excluded
     * from future batches so a broken file can't loop forever.
     */
    public function compressBatch(Request $request)
    {
        $limit              = max(1, (int) $request->input('limit', 10));
        $excludedAvatarIds  = $request->input('excluded_avatar_ids', []);
        $excludedPhotoIds   = $request->input('excluded_photo_ids', []);

        $compressed      = 0;
        $failedAvatarIds = [];
        $failedPhotoIds  = [];
        $failedDetails   = [];
        $remainingLimit  = $limit;

        $avatarUsers = User::whereNotNull('avatar')
            ->where('avatar', 'not like', '%.webp')
            ->whereNotIn('id', $excludedAvatarIds)
            ->limit($remainingLimit)
            ->get();

        foreach ($avatarUsers as $user) {
            $reason = null;
            $newPath = ImageCompressionService::compressToWebp($user->avatar, 'public', 75, 1080, $reason);

            if ($newPath) {
                $user->update(['avatar' => $newPath]);
                $compressed++;
            } else {
                $failedAvatarIds[] = $user->id;
                $failedDetails[] = [
                    'type'   => 'avatar',
                    'id'     => $user->id,
                    'path'   => $user->avatar,
                    'reason' => $reason,
                ];
            }

            $remainingLimit--;
        }

        if ($remainingLimit > 0) {
            $photos = Photo::where('path', 'not like', '%.webp')
                ->whereNotIn('id', $excludedPhotoIds)
                ->limit($remainingLimit)
                ->get();

            foreach ($photos as $photo) {
                $reason = null;
                $newPath = ImageCompressionService::compressToWebp($photo->path, 'public', 75, 1080, $reason);

                if ($newPath) {
                    $photo->update(['path' => $newPath]);
                    $compressed++;
                } else {
                    $failedPhotoIds[] = $photo->id;
                    $failedDetails[] = [
                        'type'   => 'photo',
                        'id'     => $photo->id,
                        'path'   => $photo->path,
                        'reason' => $reason,
                    ];
                }
            }
        }

        $allExcludedAvatarIds = array_merge($excludedAvatarIds, $failedAvatarIds);
        $allExcludedPhotoIds  = array_merge($excludedPhotoIds, $failedPhotoIds);

        $remaining = User::whereNotNull('avatar')
                ->where('avatar', 'not like', '%.webp')
                ->whereNotIn('id', $allExcludedAvatarIds)
                ->count()
            + Photo::where('path', 'not like', '%.webp')
                ->whereNotIn('id', $allExcludedPhotoIds)
                ->count();

        return response()->json([
            'compressed'        => $compressed,
            'failed_avatar_ids' => $failedAvatarIds,
            'failed_photo_ids'  => $failedPhotoIds,
            'failed_details'    => $failedDetails,
            'remaining'         => $remaining,
        ]);
    }
}
