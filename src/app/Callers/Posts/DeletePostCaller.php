<?php

namespace App\Callers\Posts;

use App\Receivers\Posts\DeletePostReceiver;
use App\Services\AppUtility;
use Raid\Caller\Callers\Implementations\DeleteCaller;

readonly class DeletePostCaller extends DeleteCaller
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
        return DeletePostReceiver::class;
    }
}
