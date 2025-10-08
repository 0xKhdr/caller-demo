<?php

namespace App\Callers;

use App\Receivers\FetchUserReceiver;
use App\Receivers\FetchUsersReceiver;
use Raid\Caller\Callers\CallerAbstract;
use Raid\Caller\Callers\GetCaller;

class FetchUsersCaller extends GetCaller
{
    public function __construct(
        protected readonly int $page
    ) {
    }

    public static function make(int $page): static
    {
        return new static(
            page: $page
        );
    }

    public function getUrl(): string
    {
        return "https://jsonplaceholder.typicode.com/users";
    }

    public function getOptions(): array
    {
        return [
            'query' => [
                '_page' => $this->page,
            ],
        ];
    }

    public function getReceiver(): string
    {
        return FetchUsersReceiver::class;
    }
}
