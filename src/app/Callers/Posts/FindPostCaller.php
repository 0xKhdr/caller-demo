<?php

namespace App\Callers\Posts;

use App\Receivers\Posts\FindPostReceiver;
use App\Services\AppUtility;
use Raid\Caller\Callers\GetCaller;

readonly class FindPostCaller extends GetCaller
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
        return AppUtility::getJsonPlaceholderUrl("/posts/$this->id");
    }

    public function getReceiver(): string
    {
        return FindPostReceiver::class;
    }
}
