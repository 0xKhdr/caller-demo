<?php

namespace App\Dtos;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Raid\Caller\Dtos\ResponseDtoAbstract;

class UserDto extends ResponseDtoAbstract
{
    public function __construct(
        protected readonly ?string $externalId,
        protected readonly ?string $name,
        protected readonly ?string $username,
        protected readonly ?string $companyName,
        protected readonly ?array $address,
    ) {}

    public static function fromResponse(Response $response): static
    {
        $data = $response->json();

        return new static(
            externalId: Arr::get($data, 'id'),
            name: Arr::get($data, 'name'),
            username: Arr::get($data, 'username'),
            companyName: Arr::get($data, 'company.name'),
            address: [
                'latitude' => Arr::get($data, 'address.geo.lat'),
                'longitude' => Arr::get($data, 'address.geo.lng'),
            ]
        );
    }

    public function toArray(): array
    {
        return [
            'external_id' => $this->externalId,
            'name' => $this->name,
            'username' => $this->username,
            'company_name' => $this->companyName,
            'address' => $this->address,
        ];
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function getCoordinates(): ?string
    {
        if (
            is_null($this->address) ||
            is_null($latitude = Arr::get($this->address, 'latitude')) ||
            is_null($longitude = Arr::get($this->address, 'longitude'))

        ) {
            return null;
        }

        return $latitude.','.$longitude;
    }

    public function has(string $key): bool
    {
        return isset($this->$key);
    }
}
