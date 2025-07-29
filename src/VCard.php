<?php

namespace Rumenx\PhpVcard;

/**
 * Class VCard
 *
 * Generates vCard (VCF) files compatible with major contact managers.
 * Supports common and advanced vCard fields, and custom fields.
 */
class VCard
{
    /**
     * @var array<string, string> vCard fields and their values
     */
    private array $fields = [];

    /**
     * Set the name fields (N and FN)
     */
    public function addName(string $firstName, string $lastName): self
    {
        $this->fields['N'] = "$lastName;$firstName";
        $this->fields['FN'] = "$firstName $lastName";
        return $this;
    }

    /**
     * Add an email address
     */
    public function addEmail(string $email): self
    {
        $this->fields['EMAIL'] = $email;
        return $this;
    }

    /**
     * Add a phone number
     */
    public function addPhone(string $phone): self
    {
        $this->fields['TEL'] = $phone;
        return $this;
    }

    /**
     * Add a postal address
     */
    public function addAddress(string $street, string $city, string $state, string $zip, string $country): self
    {
        $this->fields['ADR'] = ";;$street;$city;$state;$zip;$country";
        return $this;
    }

    /**
     * Add organization and optional unit/department
     */
    public function addOrganization(string $organization, ?string $unit = null): self
    {
        $this->fields['ORG'] = $unit ? "$organization;$unit" : $organization;
        return $this;
    }

    /**
     * Add a job title
     */
    public function addTitle(string $title): self
    {
        $this->fields['TITLE'] = $title;
        return $this;
    }

    /**
     * Add a URL (website)
     */
    public function addUrl(string $url): self
    {
        $this->fields['URL'] = $url;
        return $this;
    }

    /**
     * Add a note or description
     */
    public function addNote(string $note): self
    {
        $this->fields['NOTE'] = $note;
        return $this;
    }

    /**
     * Add a birthday (YYYY-MM-DD)
     */
    public function addBirthday(string $date): self
    {
        $this->fields['BDAY'] = $date;
        return $this;
    }

    /**
     * Add a photo URL
     */
    public function addPhoto(string $url): self
    {
        $this->fields['PHOTO'] = $url;
        return $this;
    }

    /**
     * Add a custom vCard field
     *
     * @param string $key Field name (e.g. X-NICKNAME)
     * @param string $value Field value
     */
    public function addCustom(string $key, string $value): self
    {
        $this->fields[strtoupper($key)] = $value;
        return $this;
    }

    /**
     * Generate the vCard as a string
     */
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

    /**
     * Save the vCard to a file
     */
    public function saveToFile(string $filename): void
    {
        file_put_contents($filename, $this->toString());
    }
}
