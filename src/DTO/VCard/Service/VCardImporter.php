<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\Service;

use InvalidArgumentException;
use lindesbs\userobject\DTO\VCard\Enum\{AddressType, EmailType, PhoneType};
use lindesbs\userobject\DTO\VCard\VCard;

class VCardImporter
{
    public function import(string $content): VCard
    {
        $lines = array_filter(explode("\n", str_replace("\r\n", "\n", $content)));
        if (!$lines || trim($lines[0]) !== 'BEGIN:VCARD') {
            throw new InvalidArgumentException('Invalid vCard format: must start with BEGIN:VCARD');
        }

        $vcard = new VCard();
        $currentProperty = '';
        $currentValue = '';

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === 'BEGIN:VCARD' || $line === 'END:VCARD') {
                continue;
            }

            // Handle line folding
            if (str_starts_with($line, ' ') || str_starts_with($line, "\t")) {
                $currentValue .= substr($line, 1);
                continue;
            }

            // Process the previous property if exists
            if ($currentProperty) {
                $this->processProperty($vcard, $currentProperty, $currentValue);
            }

            // Parse new property
            if (!str_contains($line, ':')) {
                continue;
            }

            [$currentProperty, $currentValue] = explode(':', $line, 2);
            $currentValue = $this->unescapeValue($currentValue);
        }

        // Process the last property
        if ($currentProperty) {
            $this->processProperty($vcard, $currentProperty, $currentValue);
        }

        return $vcard;
    }

    private function processProperty(VCard $vcard, string $property, string $value): void
    {
        $params = [];
        if (str_contains($property, ';')) {
            [$property, $paramString] = explode(';', $property, 2);
            $params = $this->parseParameters($paramString);
        }

        $property = strtoupper($property);

        switch ($property) {
            case 'VERSION':
                // Version is already set in VCard constructor
                break;

            case 'FN':
                $vcard->getIdentification()->setFormattedName($value);
                break;

            case 'N':
                $parts = explode(';', $value);
                $vcard->getIdentification()->setName(
                    $parts[0] ?? null,
                    $parts[1] ?? null,
                    explode(',', $parts[2] ?? ''),
                    explode(',', $parts[3] ?? ''),
                    explode(',', $parts[4] ?? '')
                );
                break;

            case 'NICKNAME':
                $vcard->getIdentification()->setNickname($value);
                break;

            case 'PHOTO':
                $vcard->getIdentification()->setPhoto($value);
                break;

            case 'BDAY':
                $vcard->getIdentification()->setBirthday($value);
                break;

            case 'EMAIL':
                $types = $this->parseTypes($params['TYPE'] ?? '', EmailType::class);
                $vcard->getCommunication()->addEmail($value, $types);
                break;

            case 'TEL':
                $types = $this->parseTypes($params['TYPE'] ?? '', PhoneType::class);
                $vcard->getCommunication()->addTelephone($value, $types);
                break;

            case 'ADR':
                $types = $this->parseTypes($params['TYPE'] ?? '', AddressType::class);
                $parts = explode(';', $value);
                $vcard->getAddress()->addAddress(
                    $parts[2] ?? null,  // Street
                    $parts[3] ?? null,  // Locality
                    $parts[4] ?? null,  // Region
                    $parts[5] ?? null,  // Postal Code
                    $parts[6] ?? null,  // Country
                    $types
                );
                break;

            case 'ORG':
                $parts = explode(';', $value);
                $org = array_shift($parts);
                $vcard->getOrganizational()->setOrganization($org, $parts);
                break;

            case 'TITLE':
                $vcard->getOrganizational()->setTitle($value);
                break;

            case 'ROLE':
                $vcard->getOrganizational()->setRole($value);
                break;

            default:
                if (!in_array($property, ['BEGIN', 'END'])) {
                    $vcard->addCustomProperty($property, $value);
                }
                break;
        }
    }

    private function parseParameters(string $paramString): array
    {
        $params = [];
        $parts = explode(';', $paramString);

        foreach ($parts as $part) {
            if (str_contains($part, '=')) {
                [$key, $value] = explode('=', $part, 2);
                $params[strtoupper($key)] = $value;
            }
        }

        return $params;
    }

    private function parseTypes(string $typeString, string $enumClass): array
    {
        if (empty($typeString)) {
            return [];
        }

        $types = [];
        foreach (explode(',', $typeString) as $type) {
            $enumValue = $enumClass::tryFrom(strtolower($type));
            if ($enumValue) {
                $types[] = $enumValue;
            }
        }

        return $types;
    }

    private function unescapeValue(string $value): string
    {
        return strtr($value, [
            '\\\\' => '\\',
            '\\,' => ',',
            '\\;' => ';',
            '\\n' => "\n",
        ]);
    }
}
