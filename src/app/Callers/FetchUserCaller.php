<?php

namespace App\Callers;

use App\Receivers\FetchUserReceiver;
use Raid\Caller\Callers\GetCaller;

readonly class FetchUserCaller extends GetCaller
{
    public function __construct(
        protected string $id
    ) {}

    public static function make(string $id): static
    {
        return new static(
            id: $id
        );
    }

    public function getUrl(): string
    {
        return "https://jsonplaceholder.typicode.com/users/$this->id";
    }

    public function getReceiver(): string
    {
        return FetchUserReceiver::class;
    }
}
