<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use MatthiasMullie\Minify\CSS;
use MatthiasMullie\Minify\JS;

class MinifyController extends Controller
{
    public function minify(Request $request, $any)
    {
        $path = public_path($any);

        // Cache the checksum of the file
        $checksum = Cache::remember("file_checksum:{$path}", 60 * 24 * 365, function () use ($path) {
            return md5_file($path);
        });

        // Cache the file content based on the checksum
        $content = Cache::remember("file_content:{$checksum}", 60 * 24 * 365, function () use ($path, $any) {
            $extension = pathinfo($any, PATHINFO_EXTENSION);

            switch ($extension) {
                case 'css':
                    $minifier = new CSS($path);
                    $minifiedContent = $minifier->minify();
                    return ['content' => $minifiedContent, 'headers' => ['Content-Type' => 'text/css']];
                case 'js':
                    $minifier = new JS($path);
                    $minifiedContent = $minifier->minify();
                    return ['content' => $minifiedContent, 'headers' => ['Content-Type' => 'application/javascript']];
                default:
                    return ['content' => file_get_contents($path), 'headers' => ['Content-Type' => 'text/plain']];
            }
        });

        // Set content and headers
        $response = response($content['content'], 200, $content['headers']);

        // Set Cache-Control, Expires and ETag headers for browser caching
        $cacheDuration = 60 * 24 * 365; // 1 year in minutes
        return $response->header('Cache-Control', "public, max-age=" . ($cacheDuration * 60))
            ->header('Expires', now()->addMinutes($cacheDuration)->toRfc7231String())
            ->header('ETag', $checksum); // ETag for validation
    }
}
