<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\Property;

class CalendarProperty
{
    private ?string $freebusy = null;
    private ?string $calendarUri = null;
    private ?string $calendarAddressUri = null;

    public function setFreebusy(?string $freebusy): self
    {
        $this->freebusy = $freebusy;
        return $this;
    }

    public function setCalendarUri(?string $uri): self
    {
        $this->calendarUri = $uri;
        return $this;
    }

    public function setCalendarAddressUri(?string $uri): self
    {
        $this->calendarAddressUri = $uri;
        return $this;
    }

    public function getFreebusy(): ?string
    {
        return $this->freebusy;
    }

    public function getCalendarUri(): ?string
    {
        return $this->calendarUri;
    }

    public function getCalendarAddressUri(): ?string
    {
        return $this->calendarAddressUri;
    }
}
