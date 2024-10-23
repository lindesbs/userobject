<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\Property;

use lindesbs\userobject\DTO\VCard\ValueObject\{Email, Phone};

class CommunicationProperty
{
    /** @var Email[] */
    private array $emails = [];
    /** @var Phone[] */
    private array $telephones = [];
    private array $impps = [];
    private ?string $language = null;

    public function addEmail(string $email, array $types = []): self
    {
        $this->emails[] = new Email($email, $types);
        return $this;
    }

    public function addTelephone(string $telephone, array $types = []): self
    {
        $this->telephones[] = new Phone($telephone, $types);
        return $this;
    }

    public function addImpp(string $impp, string $service, array $types = []): self
    {
        $this->impps[] = [
            'value' => $impp,
            'service' => $service,
            'types' => $types
        ];
        return $this;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;
        return $this;
    }

    /** @return Email[] */
    public function getEmails(): array
    {
        return $this->emails;
    }

    /** @return Phone[] */
    public function getTelephones(): array
    {
        return $this->telephones;
    }

    public function getImpps(): array
    {
        return $this->impps;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }
}
