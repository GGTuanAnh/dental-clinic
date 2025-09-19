<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\Banner;

class MediaController extends Controller
{
    public function service(Request $request, $id)
    {
        $s = Service::findOrFail($id);
        if (!$s->image) abort(404);
        return $this->streamImage($s->image, $s->image_mime ?? 'image/jpeg', $request, 'service-'.$s->id.'-'.optional($s->updated_at)->timestamp);
    }

    public function doctor(Request $request, $id)
    {
        $d = Doctor::findOrFail($id);
        if (!$d->photo) abort(404);
        return $this->streamImage($d->photo, $d->photo_mime ?? 'image/jpeg', $request, 'doctor-'.$d->id.'-'.optional($d->updated_at)->timestamp);
    }

    public function banner(Request $request, $id)
    {
        $b = Banner::findOrFail($id);
        if (!$b->image) abort(404);
        return $this->streamImage($b->image, $b->image_mime ?? 'image/jpeg', $request, 'banner-'.$b->id.'-'.optional($b->updated_at)->timestamp);
    }

    private function streamImage(string $binary, string $mime, Request $request, string $etagSeed)
    {
        $w = max(0, (int)$request->query('w', 0));
        $h = max(0, (int)$request->query('h', 0));
        $fit = in_array($request->query('fit'), ['cover','contain'], true) ? $request->query('fit') : null;
        $dpr = max(1, min(3, (float)$request->query('dpr', 1)));
        $fmt = strtolower((string)$request->query('f', ''));
        if (!in_array($fmt, ['jpg','jpeg','png','webp'], true)) { $fmt = ''; }
        $q = (int)$request->query('q', 82); $q = max(40, min(95, $q));

        // If no transform requested, send original with cache policy based on version param
        $hasTransform = ($w>0 || $h>0 || $fmt !== '' || $dpr>1);
        if (!$hasTransform) {
            return response($binary)
                ->header('Content-Type', $mime)
                ->header('Cache-Control', $request->has('v') ? 'public, max-age=31536000, immutable' : 'no-store, no-cache, must-revalidate, max-age=0')
                ->header('Pragma', $request->has('v') ? 'public' : 'no-cache');
        }

        // Build cache key
        $key = sha1($etagSeed.'|'.$mime.'|'.$w.'x'.$h.'|'.$fit.'|'.$dpr.'|'.$fmt.'|'.$q);
        $cacheDir = storage_path('app/media-cache');
        if (!is_dir($cacheDir)) @mkdir($cacheDir, 0775, true);
        $cacheFile = $cacheDir.DIRECTORY_SEPARATOR.$key;
        $cacheMimeFile = $cacheFile.'.mime';

        if (is_file($cacheFile) && is_file($cacheMimeFile)) {
            $out = file_get_contents($cacheFile);
            $outMime = trim(@file_get_contents($cacheMimeFile)) ?: $mime;
            return response($out)
                ->header('Content-Type', $outMime)
                ->header('Cache-Control', 'public, max-age=31536000, immutable')
                ->header('ETag', 'W/"'.$key.'"');
        }

        // GD-based transform (fallback to original if GD missing)
        if (!function_exists('imagecreatefromstring')) {
            return response($binary)->header('Content-Type', $mime);
        }
        $src = @imagecreatefromstring($binary);
        if (!$src) {
            return response($binary)->header('Content-Type', $mime);
        }
        $srcW = imagesx($src); $srcH = imagesy($src);

        $targetW = $w ? (int)round($w * $dpr) : 0;
        $targetH = $h ? (int)round($h * $dpr) : 0;
        if (!$targetW && !$targetH) { $targetW = $srcW; $targetH = $srcH; }
        elseif ($targetW && !$targetH) { $targetH = (int)round($srcH * ($targetW / $srcW)); }
        elseif (!$targetW && $targetH) { $targetW = (int)round($srcW * ($targetH / $srcH)); }

        $dst = imagecreatetruecolor($targetW, $targetH);
        // Preserve transparency for PNG/WebP when keeping those formats
        $targetFmt = $fmt ?: ($this->mimeToExt($mime) ?: 'jpg');
        if (in_array($targetFmt, ['png','webp'], true)) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
            imagefilledrectangle($dst, 0, 0, $targetW, $targetH, $transparent);
        } else {
            // Fill white background for JPEG
            $white = imagecolorallocate($dst, 255, 255, 255);
            imagefilledrectangle($dst, 0, 0, $targetW, $targetH, $white);
        }

        // Compute copy area
        $srcX = 0; $srcY = 0; $srcCopyW = $srcW; $srcCopyH = $srcH;
        if ($fit === 'cover') {
            $ratioSrc = $srcW / max(1,$srcH);
            $ratioDst = $targetW / max(1,$targetH);
            if ($ratioDst > $ratioSrc) {
                // wider target: crop vertical
                $newH = (int)round($srcW / max(0.0001,$ratioDst));
                $srcY = (int)max(0, ($srcH - $newH) / 2);
                $srcCopyH = max(1, $newH);
            } else {
                // taller target: crop horizontal
                $newW = (int)round($srcH * $ratioDst);
                $srcX = (int)max(0, ($srcW - $newW) / 2);
                $srcCopyW = max(1, $newW);
            }
        }

        imagecopyresampled($dst, $src, 0, 0, $srcX, $srcY, $targetW, $targetH, $srcCopyW, $srcCopyH);

        // Encode
        ob_start();
        $outMime = $mime;
        if ($targetFmt === 'webp' && function_exists('imagewebp')) {
            imagewebp($dst, null, $q);
            $outMime = 'image/webp';
        } elseif (in_array($targetFmt, ['jpg','jpeg'], true)) {
            imagejpeg($dst, null, $q);
            $outMime = 'image/jpeg';
        } elseif ($targetFmt === 'png') {
            // Convert quality 0-9 scale
            $pngQ = (int)round((100 - $q) / 11.111);
            imagepng($dst, null, $pngQ);
            $outMime = 'image/png';
        } else {
            // fallback to original
            imagejpeg($dst, null, $q);
            $outMime = 'image/jpeg';
        }
        $out = ob_get_clean();
        imagedestroy($src); imagedestroy($dst);

        // Cache and respond
        @file_put_contents($cacheFile, $out);
        @file_put_contents($cacheMimeFile, $outMime);
        return response($out)
            ->header('Content-Type', $outMime)
            ->header('Cache-Control', 'public, max-age=31536000, immutable')
            ->header('ETag', 'W/"'.$key.'"');
    }

    private function mimeToExt(?string $mime): ?string
    {
        $map = [
            'image/jpeg' => 'jpg',
            'image/jpg'  => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        ];
        return $mime && isset($map[$mime]) ? $map[$mime] : null;
    }
}
