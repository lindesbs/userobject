<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\ValueObject;

use lindesbs\userobject\DTO\VCard\Enum\EmailType;

class Email
{
    /**
     * @param string $address
     * @param EmailType[] $types
     */
    public function __construct(
        private readonly string $address,
        private readonly array $types = []
    ) {
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    /** @return EmailType[] */
    public function getTypes(): array
    {
        return $this->types;
    }
}
