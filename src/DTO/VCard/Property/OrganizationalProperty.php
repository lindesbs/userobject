<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\Property;

class OrganizationalProperty
{
    private ?string $title = null;
    private ?string $role = null;
    private ?string $organization = null;
    private ?array $organizationalUnits = [];
    private ?string $logo = null;
    private ?array $related = [];

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function setOrganization(?string $organization, array $units = []): self
    {
        $this->organization = $organization;
        $this->organizationalUnits = $units;
        return $this;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;
        return $this;
    }

    public function addRelated(string $value, string $type): self
    {
        $this->related[] = [
            'value' => $value,
            'type' => $type
        ];
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function getOrganizationalUnits(): array
    {
        return $this->organizationalUnits;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function getRelated(): array
    {
        return $this->related;
    }
}
