<?php

use App\Http\Controllers\Basic\PostController as BasicPostController;
use App\Http\Controllers\Caller\PostController as CallerPostController;
use App\Http\Controllers\Caller\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Caller routes
Route::get('/caller/{domain}/{action}', function (Request $request, string $domain, string $action) {
    $controller = match ($domain) {
        'users' => new UserController,
        'posts' => new CallerPostController,
        default => throw new Exception(sprintf('Domain %s not found', $domain)),
    };

    if (! method_exists($controller, $action)) {
        throw new Exception(sprintf('Action %s not found in %s domain', $action, $domain));
    }

    return $controller->{$action}($request);
})
    ->where('domain', 'users|posts')
    ->where('action', 'index|find|store|update|patch|delete');

// Basic and Caller routes
Route::get('/{version}/{action}', function (Request $request, string $version, string $action) {
    $controller = match ($version) {
        'basic' => new BasicPostController,
        'caller' => new CallerPostController,
        default => throw new Exception(sprintf('Version %s not found', $version)),
    };

    if (! method_exists($controller, $action)) {
        throw new Exception(sprintf('Action %s not found in %s version', $action, $version));
    }

    return $controller->{$action}($request);
})
    ->where('version', 'basic|caller')
    ->where('action', 'index|find|store|update|patch|delete');
