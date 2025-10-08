<?php

namespace App\Callers;

use App\Receivers\FetchUserReceiver;
use Raid\Caller\Callers\CallerAbstract;

class FetchUserCaller extends CallerAbstract
{
    public function __construct(
        protected readonly string $id
    ) {}

    public static function make(string $id): static
    {
        return new static($id);
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getUrl(): string
    {
        return "https://jsonplaceholder.typicode.com/users/$this->id";
    }

    public function getReceiver(): string
    {
        return FetchUserReceiver::class;
    }
}
