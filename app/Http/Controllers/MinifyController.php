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
        if (!is_file($path))
            abort(404);
        // Cache the checksum of the file
        $checksum = md5_file($path);
        $cacheDuration = 60 * 60 * 24 * 30 * 12; // 1 year in minutes

        // Cache the file content based on the checksum
        $content = Cache::remember("file_content:{$checksum}", $cacheDuration, function () use ($path, $any) {
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
        return $response->header('Cache-Control', "public, max-age=" . ($cacheDuration))
            ->header('Expires', now()->addMinutes($cacheDuration)->toRfc7231String())
            ->header('ETag', $checksum); // ETag for validation
    }
}
