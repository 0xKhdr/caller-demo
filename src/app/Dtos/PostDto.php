<?php

namespace App\Dtos;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Raid\Caller\Dtos\DtoAbstract;

readonly class PostDto extends DtoAbstract
{
    public function __construct(
        protected ?string $id,
        protected ?string $userId,
        protected ?string $title,
        protected ?string $body
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            id: Arr::get($data, 'id'),
            userId: Arr::get($data, 'userId'),
            title: Arr::get($data, 'title'),
            body: Arr::get($data, 'body'),
        );
    }

    public static function fromResponse(Response $response): static
    {
        return self::fromArray($response->json());
    }

    public function toArray(): array
    {
        return [
            'external_id' => $this->id,
            'user_id' => $this->userId,
            'title' => $this->title,
            'body' => $this->body,
        ];
    }

    public function getExternalId(): ?string
    {
        return $this->id;
    }
}
