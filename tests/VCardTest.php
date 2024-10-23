<?php

declare(strict_types=1);

namespace lindesbs\userobject\Tests;

use PHPUnit\Framework\TestCase;
use lindesbs\userobject\DTO\VCard\VCard;
use lindesbs\userobject\DTO\VCard\Enum\EmailType;
use lindesbs\userobject\DTO\VCard\Enum\PhoneType;

class VCardTest extends TestCase
{
    public function testCreateBasicVCard(): void
    {
        $vcard = new VCard();

        $vcard->getIdentification()
            ->setFormattedName('John Doe')
            ->setName('Doe', 'John')
            ->setNickname('Johnny');

        $vcard->getCommunication()
            ->addEmail('john.doe@example.com', [EmailType::WORK])
            ->addTelephone('+1234567890', [PhoneType::CELL]);

        $vcard->getOrganizational()
            ->setTitle('Software Developer')
            ->setOrganization('Tech Corp');

        $output = $vcard->toString();

        $this->assertStringContainsString('BEGIN:VCARD', $output);
        $this->assertStringContainsString('VERSION:4.0', $output);
        $this->assertStringContainsString('FN:John Doe', $output);
        $this->assertStringContainsString('N:Doe;John;;;', $output);
        $this->assertStringContainsString('NICKNAME:Johnny', $output);
        $this->assertStringContainsString('EMAIL;TYPE=work:john.doe@example.com', $output);
        $this->assertStringContainsString('TEL;TYPE=cell:+1234567890', $output);
        $this->assertStringContainsString('TITLE:Software Developer', $output);
        $this->assertStringContainsString('ORG:Tech Corp', $output);
        $this->assertStringContainsString('END:VCARD', $output);
    }

    public function testImportVCard(): void
    {
        $vcardString = "BEGIN:VCARD\r\n" .
            "VERSION:4.0\r\n" .
            "FN:John Doe\r\n" .
            "N:Doe;John;;;\r\n" .
            "EMAIL;TYPE=work:john.doe@example.com\r\n" .
            "TEL;TYPE=cell:+1234567890\r\n" .
            "END:VCARD";

        $vcard = VCard::fromString($vcardString);

        $this->assertEquals('John Doe', $vcard->getIdentification()->getFormattedName());
        $this->assertEquals('Doe', $vcard->getIdentification()->getFamilyName());
        $this->assertEquals('John', $vcard->getIdentification()->getGivenName());

        $emails = $vcard->getCommunication()->getEmails();
        $this->assertCount(1, $emails);
        $this->assertEquals('john.doe@example.com', $emails[0]->getAddress());
        $this->assertEquals(EmailType::WORK, $emails[0]->getTypes()[0]);

        $phones = $vcard->getCommunication()->getTelephones();
        $this->assertCount(1, $phones);
        $this->assertEquals('+1234567890', $phones[0]->getNumber());
        $this->assertEquals(PhoneType::CELL, $phones[0]->getTypes()[0]);
    }
}
