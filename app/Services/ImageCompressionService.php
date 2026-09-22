<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageCompressionService
{
    /**
     * Store a freshly uploaded file directly as a compressed .webp.
     * The original (jpg/png/gif/webp) is never written to disk —
     * only the compressed webp version is saved.
     *
     * Returns the relative path (e.g. "avatars/abc123.webp").
     */
    public static function storeUploadedAsWebp(
        UploadedFile $file,
        string $directory,
        string $disk = 'public',
        int $quality = 75,
        int $maxWidth = 1080
    ): string {
        $tmpPath = $file->getRealPath();

        $imageInfo = getimagesize($tmpPath);
        if ($imageInfo === false) {
            throw new \RuntimeException('Uploaded file is not a valid image.');
        }

        [$width, $height, $type] = $imageInfo;

        $source = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($tmpPath),
            IMAGETYPE_PNG  => imagecreatefrompng($tmpPath),
            IMAGETYPE_GIF  => imagecreatefromgif($tmpPath),
            IMAGETYPE_WEBP => imagecreatefromwebp($tmpPath),
            default        => throw new \RuntimeException('Unsupported image type.'),
        };

        $source = self::resizeIfNeeded($source, $width, $height, $maxWidth);

        $filename     = uniqid() . '_' . time() . '.webp';
        $relativePath = trim($directory, '/') . '/' . $filename;

        ob_start();
        imagewebp($source, null, $quality);
        $webpData = ob_get_clean();
        imagedestroy($source);

        Storage::disk($disk)->put($relativePath, $webpData);

        return $relativePath;
    }

    /**
     * Compress an EXISTING stored image (already on disk) and convert it to .webp.
     * Deletes the original file once the webp version is saved.
     *
     * Returns the new relative path, or null on failure. When it returns null,
     * $reason (passed by reference) is filled with a human-readable explanation —
     * pass a variable to inspect why a specific file failed.
     */
    public static function compressToWebp(
        ?string $relativePath,
        string $disk = 'public',
        int $quality = 75,
        int $maxWidth = 1080,
        ?string &$reason = null
    ): ?string {
        if (!$relativePath) {
            $reason = 'No path stored for this record.';
            return null;
        }

        if (strtolower(pathinfo($relativePath, PATHINFO_EXTENSION)) === 'webp') {
            $reason = 'Already webp.';
            return null;
        }

        $storage = Storage::disk($disk);

        if (!$storage->exists($relativePath)) {
            $reason = 'File not found at resolved path: ' . $storage->path($relativePath);
            return null;
        }

        $fullPath = $storage->path($relativePath);

        $imageInfo = @getimagesize($fullPath);
        if ($imageInfo === false) {
            $reason = 'getimagesize() failed for: ' . $fullPath . ' (file may be corrupt or unreadable).';
            return null;
        }

        [$width, $height, $type] = $imageInfo;

        $source = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($fullPath),
            IMAGETYPE_PNG  => @imagecreatefrompng($fullPath),
            IMAGETYPE_GIF  => @imagecreatefromgif($fullPath),
            IMAGETYPE_WEBP => @imagecreatefromwebp($fullPath),
            default        => null,
        };

        if (!$source) {
            $reason = 'Unsupported or unreadable image type (detected GD type: ' . $type . ') at: ' . $fullPath;
            return null;
        }

        $source = self::resizeIfNeeded($source, $width, $height, $maxWidth);

        $directory       = pathinfo($relativePath, PATHINFO_DIRNAME);
        $filename        = pathinfo($relativePath, PATHINFO_FILENAME);
        $newRelativePath = ($directory === '.' ? '' : $directory . '/') . $filename . '.webp';
        $newFullPath     = $storage->path($newRelativePath);

        $written = imagewebp($source, $newFullPath, $quality);
        imagedestroy($source);

        if (!$written || !$storage->exists($newRelativePath)) {
            $reason = 'imagewebp() failed to write ' . $newFullPath . ' — your PHP/GD build may be missing WebP support.';
            return null;
        }

        $storage->delete($relativePath);

        return $newRelativePath;
    }

    /**
     * Downscale an image resource if it's wider than $maxWidth, preserving
     * aspect ratio and transparency. Returns the (possibly new) resource.
     */
    private static function resizeIfNeeded($source, int $width, int $height, int $maxWidth)
    {
        if ($width <= $maxWidth) {
            return $source;
        }

        $newWidth  = $maxWidth;
        $newHeight = (int) round($height * ($maxWidth / $width));

        $resized = imagecreatetruecolor($newWidth, $newHeight);

        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
        imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);

        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($source);

        return $resized;
    }
}
