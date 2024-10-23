<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\Service;

use lindesbs\userobject\DTO\VCard\VCard;

class VCardExporter
{
    public function export(VCard $vcard): string
    {
        $lines = [];
        $lines[] = 'BEGIN:VCARD';
        $lines[] = 'VERSION:' . $vcard->getVersion();

        // Identification
        $identification = $vcard->getIdentification();
        if ($identification->getFormattedName()) {
            $lines[] = 'FN:' . $this->escapeValue($identification->getFormattedName());
        }

        if ($identification->getFamilyName() || $identification->getGivenName()) {
            $n = implode(';', [
                $identification->getFamilyName() ?? '',
                $identification->getGivenName() ?? '',
                implode(',', $identification->getAdditionalNames()),
                implode(',', $identification->getHonorificPrefixes()),
                implode(',', $identification->getHonorificSuffixes())
            ]);
            $lines[] = 'N:' . $this->escapeValue($n);
        }

        if ($identification->getNickname()) {
            $lines[] = 'NICKNAME:' . $this->escapeValue($identification->getNickname());
        }

        if ($identification->getPhoto()) {
            $lines[] = 'PHOTO:' . $this->escapeValue($identification->getPhoto());
        }

        if ($identification->getBirthday()) {
            $lines[] = 'BDAY:' . $this->escapeValue($identification->getBirthday());
        }

        if ($identification->getGender()) {
            $lines[] = 'GENDER:' . $this->escapeValue($identification->getGender());
        }

        // Communication
        $communication = $vcard->getCommunication();
        foreach ($communication->getEmails() as $email) {
            $types = array_map(fn($type) => $type->value, $email->getTypes());
            $typeStr = $types ? ';TYPE=' . implode(',', $types) : '';
            $lines[] = 'EMAIL' . $typeStr . ':' . $this->escapeValue($email->getAddress());
        }

        foreach ($communication->getTelephones() as $phone) {
            $types = array_map(fn($type) => $type->value, $phone->getTypes());
            $typeStr = $types ? ';TYPE=' . implode(',', $types) : '';
            $lines[] = 'TEL' . $typeStr . ':' . $this->escapeValue($phone->getNumber());
        }

        if ($communication->getLanguage()) {
            $lines[] = 'LANG:' . $this->escapeValue($communication->getLanguage());
        }

        // Address
        $addressProp = $vcard->getAddress();
        foreach ($addressProp->getAddresses() as $address) {
            $types = array_map(fn($type) => $type->value, $address->getTypes());
            $typeStr = $types ? ';TYPE=' . implode(',', $types) : '';
            $adr = implode(';', [
                '',  // Post office box
                '',  // Extended address
                $address->getStreet() ?? '',
                $address->getLocality() ?? '',
                $address->getRegion() ?? '',
                $address->getPostalCode() ?? '',
                $address->getCountry() ?? ''
            ]);
            $lines[] = 'ADR' . $typeStr . ':' . $this->escapeValue($adr);
        }

        if ($addressProp->getTimeZone()) {
            $lines[] = 'TZ:' . $this->escapeValue($addressProp->getTimeZone());
        }

        if ($geo = $addressProp->getGeo()) {
            $lines[] = 'GEO:' . $geo->getLatitude() . ',' . $geo->getLongitude();
        }

        // Organizational
        $org = $vcard->getOrganizational();
        if ($org->getTitle()) {
            $lines[] = 'TITLE:' . $this->escapeValue($org->getTitle());
        }

        if ($org->getRole()) {
            $lines[] = 'ROLE:' . $this->escapeValue($org->getRole());
        }

        if ($org->getOrganization()) {
            $orgValue = $org->getOrganization();
            if ($org->getOrganizationalUnits()) {
                $orgValue .= ';' . implode(';', $org->getOrganizationalUnits());
            }
            $lines[] = 'ORG:' . $this->escapeValue($orgValue);
        }

        if ($org->getLogo()) {
            $lines[] = 'LOGO:' . $this->escapeValue($org->getLogo());
        }

        // Calendar
        $calendar = $vcard->getCalendar();
        if ($calendar->getFreebusy()) {
            $lines[] = 'FBURL:' . $this->escapeValue($calendar->getFreebusy());
        }

        if ($calendar->getCalendarUri()) {
            $lines[] = 'CALURI:' . $this->escapeValue($calendar->getCalendarUri());
        }

        // Security
        $security = $vcard->getSecurity();
        if ($security->getPublicKey()) {
            $key = 'KEY:' . $this->escapeValue($security->getPublicKey());
            if ($security->getKeyType()) {
                $key = 'KEY;TYPE=' . $security->getKeyType() . ':' . $this->escapeValue($security->getPublicKey());
            }
            $lines[] = $key;
        }

        // Custom properties
        foreach ($vcard->getCustomProperties() as $name => $value) {
            $lines[] = $name . ':' . $this->escapeValue($value);
        }

        $lines[] = 'END:VCARD';

        return implode("\r\n", $lines);
    }

    private function escapeValue(string $value): string
    {
        return strtr($value, [
            '\\' => '\\\\',
            ',' => '\\,',
            ';' => '\\;',
            "\n" => '\\n',
        ]);
    }
}
