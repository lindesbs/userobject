<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\ValueObject;

use lindesbs\userobject\DTO\VCard\Enum\PhoneType;

class Phone
{
    /**
     * @param string $number
     * @param PhoneType[] $types
     */
    public function __construct(
        private readonly string $number,
        private readonly array $types = []
    ) {
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    /** @return PhoneType[] */
    public function getTypes(): array
    {
        return $this->types;
    }
}
