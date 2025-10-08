<?php

namespace App\Callers\Users;

use App\Receivers\Users\FindUserReceiver;
use Raid\Caller\Callers\GetCaller;

readonly class FindUserCaller extends GetCaller
{
    public function __construct(
        protected int $id
    ) {}

    public static function make(int $id): static
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
        return FindUserReceiver::class;
    }
}
