<?php

namespace App\Callers\Posts;

use App\Receivers\Posts\GetPostsReceiver;
use App\Services\AppUtility;
use Raid\Caller\Callers\Implementations\GetCaller;

readonly class GetPostsCaller extends GetCaller
{
    public function __construct(
        protected ?int $page = 1,
        protected ?int $userId = null
    ) {}

    public static function make(
        ?int $page = null,
        ?int $userId = null
    ): static {
        return new static(
            page: $page,
            userId: $userId
        );
    }

    public function getUrl(): string
    {
        return AppUtility::getJsonPlaceholderUrl('/posts');
    }

    public function getOptions(): array
    {
        return [
            'query' => [
                '_page' => $this->page,
                'userId' => $this->userId,
            ],
        ];
    }

    public function getReceiver(): string
    {
        return GetPostsReceiver::class;
    }
}
