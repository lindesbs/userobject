<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\Property;

use lindesbs\userobject\DTO\VCard\ValueObject\{Address, GeoCoordinate};

class AddressProperty
{
    /** @var Address[] */
    private array $addresses = [];
    private ?string $timeZone = null;
    private ?GeoCoordinate $geo = null;

    public function addAddress(
        ?string $streetAddress = null,
        ?string $locality = null,
        ?string $region = null,
        ?string $postalCode = null,
        ?string $country = null,
        array $types = []
    ): self {
        $this->addresses[] = new Address(
            $streetAddress,
            $locality,
            $region,
            $postalCode,
            $country,
            $types
        );
        return $this;
    }

    public function setTimeZone(?string $timeZone): self
    {
        $this->timeZone = $timeZone;
        return $this;
    }

    public function setGeo(float $latitude, float $longitude): self
    {
        $this->geo = new GeoCoordinate($latitude, $longitude);
        return $this;
    }

    /** @return Address[] */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }

    public function getGeo(): ?GeoCoordinate
    {
        return $this->geo;
    }
}
