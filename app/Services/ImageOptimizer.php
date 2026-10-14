<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Throwable;

class ImageOptimizer
{
    /**
     * Compress, resize, and convert an uploaded image to modern WebP format.
     *
     * @param  string  $directory  Subfolder inside storage/app/public (e.g., 'posts', 'series', 'pages')
     * @param  int  $maxWidth  Maximum width in pixels (aspect ratio preserved, no upscaling)
     * @param  int  $quality  WebP compression quality (0-100)
     * @return string Relative path stored on the public disk
     */
    public static function optimizeAndStore(
        UploadedFile $file,
        string $directory,
        int $maxWidth = 1200,
        int $quality = 80
    ): string {
        try {
            $manager = new ImageManager(new Driver);
            $image = $manager->decode($file->getRealPath());

            // Skalakan gambar secara proporsional jika lebarnya melebihi batas maksimum
            if ($image->width() > $maxWidth) {
                $image->scaleDown(width: $maxWidth);
            }

            // Kompres otomatis ke format WebP modern
            $encoded = $image->encode(new WebpEncoder(quality: $quality));

            // Generate nama berkas acak yang unik dengan ekstensi .webp
            $filename = Str::random(40).'.webp';
            $relativePath = trim($directory, '/').'/'.$filename;

            // Simpan ke storage disk publik
            Storage::disk('public')->put($relativePath, (string) $encoded);

            return $relativePath;
        } catch (Throwable $e) {
            // Fallback aman: jika proses GD gagal, simpan file asli tanpa error
            return $file->store($directory, 'public');
        }
    }
}
