<?php

namespace App\Services;

class AppUtility
{
    public static function getJsonPlaceholderUrl(?string $path = null): string
    {
        $baseUrl = config('services.json_placeholder.base_url');

        return $path
            ? rtrim($baseUrl, '/').'/'.ltrim($path, '/')
            : $baseUrl;
    }
}
