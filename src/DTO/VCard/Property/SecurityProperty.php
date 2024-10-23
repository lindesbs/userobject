<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\Property;

class SecurityProperty
{
    private ?string $publicKey = null;
    private ?string $keyType = null;
    private ?array $certificates = [];

    public function setPublicKey(?string $key, ?string $type = null): self
    {
        $this->publicKey = $key;
        $this->keyType = $type;
        return $this;
    }

    public function addCertificate(string $certificate): self
    {
        $this->certificates[] = $certificate;
        return $this;
    }

    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }

    public function getKeyType(): ?string
    {
        return $this->keyType;
    }

    public function getCertificates(): array
    {
        return $this->certificates;
    }
}
