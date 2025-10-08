<?php

namespace App\Callers\Posts;

use App\Receivers\Posts\PatchPostReceiver;
use App\Services\AppUtility;
use Raid\Caller\Callers\PatchCaller;

readonly class PatchPostCaller extends PatchCaller
{
    public function __construct(
        protected int $id,
        protected ?int $userId = null,
        protected ?string $title = null,
        protected ?string $body = null
    ) {}

    public static function make(
        int $id,
        ?int $userId = null,
        ?string $title = null,
        ?string $body = null
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
        return PatchPostReceiver::class;
    }
}
