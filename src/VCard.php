<?php

namespace Rumenx\PhpVcard;

class VCard
{
    private array $fields = [];

    public function addName(string $firstName, string $lastName): self
    {
        $this->fields['N'] = "$lastName;$firstName";
        $this->fields['FN'] = "$firstName $lastName";
        return $this;
    }

    public function addEmail(string $email): self
    {
        $this->fields['EMAIL'] = $email;
        return $this;
    }

    public function addPhone(string $phone): self
    {
        $this->fields['TEL'] = $phone;
        return $this;
    }

    public function addAddress(string $street, string $city, string $state, string $zip, string $country): self
    {
        $this->fields['ADR'] = ";;$street;$city;$state;$zip;$country";
        return $this;
    }

    public function addOrganization(string $organization, ?string $unit = null): self
    {
        $this->fields['ORG'] = $unit ? "$organization;$unit" : $organization;
        return $this;
    }

    public function addTitle(string $title): self
    {
        $this->fields['TITLE'] = $title;
        return $this;
    }

    public function addUrl(string $url): self
    {
        $this->fields['URL'] = $url;
        return $this;
    }

    public function addNote(string $note): self
    {
        $this->fields['NOTE'] = $note;
        return $this;
    }

    public function addBirthday(string $date): self
    {
        $this->fields['BDAY'] = $date;
        return $this;
    }

    public function addPhoto(string $url): self
    {
        $this->fields['PHOTO'] = $url;
        return $this;
    }

    public function addCustom(string $key, string $value): self
    {
        $this->fields[strtoupper($key)] = $value;
        return $this;
    }

    public function toString(): string
    {
        $lines = [
            'BEGIN:VCARD',
            'VERSION:3.0',
        ];
        foreach ($this->fields as $key => $value) {
            $lines[] = "$key:$value";
        }
        $lines[] = 'END:VCARD';
        return implode("\r\n", $lines) . "\r\n";
    }

    public function saveToFile(string $filename): void
    {
        file_put_contents($filename, $this->toString());
    }
}
