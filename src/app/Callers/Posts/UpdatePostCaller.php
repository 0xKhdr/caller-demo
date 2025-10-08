<?php

namespace App\Callers\Posts;

use App\Receivers\Posts\UpdatePostReceiver;
use App\Services\AppUtility;
use Raid\Caller\Callers\PutCaller;

readonly class UpdatePostCaller extends PutCaller
{
    public function __construct(
        protected int $id,
        protected int $userId,
        protected string $title,
        protected string $body
    ) {}

    public static function make(
        int $id,
        int $userId,
        string $title,
        string $body
    ): static {
        return new static(
            id: $id,
            userId: $userId,
            title: $title,
            body: $body
        );
    }

    public function getUrl(): string
    {
        return AppUtility::getJsonPlaceholderUrl("/posts/$this->id");
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
        return UpdatePostReceiver::class;
    }
}
