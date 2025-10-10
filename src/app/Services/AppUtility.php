<?php

namespace App\Services;

class AppUtility
{
    public static function getJsonPlaceholderUrl(?string $path = null): string
    {
        $baseUrl = config('services.jsonplaceholder.url');

        return $path
            ? rtrim($baseUrl, '/').'/'.ltrim($path, '/')
            : $baseUrl;
    }
}
