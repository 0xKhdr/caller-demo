<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{domain}/{action}', function (Request $request, string $domain, string $action) {
    $controller = match ($domain) {
        'users' => new UserController,
        'posts' => new PostController,
        default => throw new Exception(sprintf('Domain %s not found', $domain)),
    };

    if (! method_exists($controller, $action)) {
        throw new Exception(sprintf('Action %s not found in %s domain', $action, $domain));
    }

    return $controller->{$action}($request);
});
