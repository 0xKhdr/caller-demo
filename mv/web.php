<?php

use App\Dtos\FindUserRequestDto;
use App\Dtos\FindUserResponseDto;
use App\Models\Caller;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/caller/{id}', function (string $userId) {
    /** @var FindUserResponseDto $response */
    $response = FindUserRequestDto::make(id: $userId)->call();
    if (!$response->isSuccessResponse()) {
        throw new Exception(sprintf('Error fetching user: %s', $userId));
    }
    $data = $response->getUser()->toArray();

    $caller = Caller::query()->firstWhere('external_id', $response->getUser()->getExternalId());
    if (!$caller) {
        $caller = Caller::query()->create(array_merge($data, [
            'last_called_at' => now(),
        ]));
    } else {
        $caller->update(array_merge(Arr::except($data, 'external_id'), [
            'last_called_at' => now(),
        ]));
    }

    return [
        'data' => $caller->fresh()->toArray(),
    ];
});
