<?php

namespace App\Dtos;

use Raid\Caller\Dtos\RequestDtoAbstract;

class FindUserRequestDto extends RequestDtoAbstract
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

    public function getResponseDto(): string
    {
        return FindUserResponseDto::class;
    }
}
