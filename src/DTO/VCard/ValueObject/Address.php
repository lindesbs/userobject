<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\ValueObject;

use lindesbs\userobject\DTO\VCard\Enum\AddressType;

class Address
{
    /**
     * @param string|null $street
     * @param string|null $locality
     * @param string|null $region
     * @param string|null $postalCode
     * @param string|null $country
     * @param AddressType[] $types
     */
    public function __construct(
        private readonly ?string $street = null,
        private readonly ?string $locality = null,
        private readonly ?string $region = null,
        private readonly ?string $postalCode = null,
        private readonly ?string $country = null,
        private readonly array $types = []
    ) {
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getLocality(): ?string
    {
        return $this->locality;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    /** @return AddressType[] */
    public function getTypes(): array
    {
        return $this->types;
    }
}
