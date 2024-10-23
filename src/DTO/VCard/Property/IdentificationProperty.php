<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\Property;

class IdentificationProperty
{
    private ?string $formattedName = null;
    private ?string $familyName = null;
    private ?string $givenName = null;
    private ?array $additionalNames = [];
    private ?array $honorificPrefixes = [];
    private ?array $honorificSuffixes = [];
    private ?string $nickname = null;
    private ?string $photo = null;
    private ?string $birthday = null;
    private ?string $gender = null;

    public function setFormattedName(?string $formattedName): self
    {
        $this->formattedName = $formattedName;
        return $this;
    }

    public function setName(?string $familyName, ?string $givenName, ?array $additionalNames = [], ?array $prefixes = [], ?array $suffixes = []): self
    {
        $this->familyName = $familyName;
        $this->givenName = $givenName;
        $this->additionalNames = $additionalNames;
        $this->honorificPrefixes = $prefixes;
        $this->honorificSuffixes = $suffixes;
        return $this;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;
        return $this;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;
        return $this;
    }

    public function setBirthday(?string $birthday): self
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    // Getters
    public function getFormattedName(): ?string
    {
        return $this->formattedName;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function getAdditionalNames(): array
    {
        return $this->additionalNames;
    }

    public function getHonorificPrefixes(): array
    {
        return $this->honorificPrefixes;
    }

    public function getHonorificSuffixes(): array
    {
        return $this->honorificSuffixes;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }
}
