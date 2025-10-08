<?php

namespace App\Callers;

use App\Receivers\StorePostReceiver;
use Raid\Caller\Callers\CallerAbstract;

readonly class StorePostCaller extends CallerAbstract
{
    public function __construct(
        protected int $userId,
        protected string $title,
        protected string $body
    ) {}

    public static function make(
        int $userId,
        string $title,
        string $body
    ): static {
        return new static(
            userId: $userId,
            title: $title,
            body: $body
        );
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUrl(): string
    {
        return 'https://jsonplaceholder.typicode.com/posts';
    }

    public function getOptions(): array
    {
        return [
            'headers' => [
                'Content-Type' => 'application/json; charset=UTF-8',
            ],
        ];
    }

    public function getReceiver(): string
    {
        return StorePostReceiver::class;
    }
}
