<?php

namespace App\Callers\Users;

use App\Receivers\Users\GetUsersReceiver;
use App\Services\AppUtility;
use Raid\Caller\Callers\GetCaller;

readonly class GetUsersCaller extends GetCaller
{
    public function __construct(
        protected ?int $page = 1
    ) {}

    public static function make(
        ?int $page = null
    ): static {
        return new static(
            page: $page
        );
    }

    public function getUrl(): string
    {
        return AppUtility::getJsonPlaceholderUrl('/users');
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
        return GetUsersReceiver::class;
    }
}
