<?php

namespace App\Dtos;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Raid\Caller\Dtos\DtoAbstract;

readonly class UserDto extends DtoAbstract
{
    public function __construct(
        protected ?string $id,
        protected ?string $name,
        protected ?string $username,
        protected ?string $companyName,
        protected ?array $address
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            id: Arr::get($data, 'id'),
            name: Arr::get($data, 'name'),
            username: Arr::get($data, 'username'),
            companyName: Arr::get($data, 'company.name'),
            address: [
                'latitude' => Arr::get($data, 'address.geo.lat'),
                'longitude' => Arr::get($data, 'address.geo.lng'),
            ]
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
            'name' => $this->name,
            'username' => $this->username,
            'company_name' => $this->companyName,
            'address' => $this->address,
        ];
    }

    public function getExternalId(): ?string
    {
        return $this->id;
    }

    public function getCoordinates(): ?string
    {
        if (
            ! $this->address ||
            ! ($latitude = Arr::get($this->address, 'latitude')) ||
            ! ($longitude = Arr::get($this->address, 'longitude'))

        ) {
            return null;
        }

        return $latitude.','.$longitude;
    }
}
