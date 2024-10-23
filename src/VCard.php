<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard;

use lindesbs\userobject\DTO\VCard\Property\{AddressProperty,
    CalendarProperty,
    CommunicationProperty,
    IdentificationProperty,
    OrganizationalProperty,
    SecurityProperty};
use lindesbs\userobject\DTO\VCard\Service\{VCardExporter, VCardImporter};

class VCard
{
    private string $version = '4.0';
    private readonly IdentificationProperty $identification;
    private readonly CommunicationProperty $communication;
    private readonly AddressProperty $address;
    private readonly OrganizationalProperty $organizational;
    private readonly CalendarProperty $calendar;
    private readonly SecurityProperty $security;

    /**
     * @param array<string, mixed> $customProperties
     */
    private array $customProperties = [];


    public function __construct()
    {
        $this->identification = new IdentificationProperty();
        $this->communication = new CommunicationProperty();
        $this->address = new AddressProperty();
        $this->organizational = new OrganizationalProperty();
        $this->calendar = new CalendarProperty();
        $this->security = new SecurityProperty();
    }

    public static function fromString(string $content): self
    {
        return (new VCardImporter())->import($content);
    }

    public function toString(): string
    {
        return (new VCardExporter())->export($this);
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getIdentification(): IdentificationProperty
    {
        return $this->identification;
    }

    public function getCommunication(): CommunicationProperty
    {
        return $this->communication;
    }

    public function getAddress(): AddressProperty
    {
        return $this->address;
    }

    public function getOrganizational(): OrganizationalProperty
    {
        return $this->organizational;
    }

    public function getCalendar(): CalendarProperty
    {
        return $this->calendar;
    }

    public function getSecurity(): SecurityProperty
    {
        return $this->security;
    }

    public function addCustomProperty(string $name, mixed $value): void
    {
        $this->customProperties[$name] = $value;
    }

    /**
     * @return array<string, mixed>
     */
    public function getCustomProperties(): array
    {
        return $this->customProperties;
    }
}
