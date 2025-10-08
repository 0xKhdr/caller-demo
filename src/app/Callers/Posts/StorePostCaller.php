<?php

namespace App\Callers\Posts;

use App\Receivers\Posts\StorePostReceiver;
use App\Services\AppUtility;
use Raid\Caller\Callers\PostCaller;

readonly class StorePostCaller extends PostCaller
{
    public function __construct(
        protected string $userId,
        protected string $title,
        protected string $body
    ) {}

    public static function make(
        string $userId,
        string $title,
        string $body
    ): static {
        return new static(
            userId: $userId,
            title: $title,
            body: $body
        );
    }

    public function getUrl(): string
    {
        return AppUtility::getJsonPlaceholderUrl('/posts');
    }

    public function getOptions(): array
    {
        return [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'userId' => $this->userId,
                'title' => $this->title,
                'body' => $this->body,
            ],
        ];
    }

    public function getReceiver(): string
    {
        return StorePostReceiver::class;
    }
}
