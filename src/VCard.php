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
     * @var array<string, string> vCard fields and their escaped values
     */
    private array $fields = [];

    /**
     * Set the name fields (N and FN)
     */
    public function addName(string $firstName, string $lastName): self
    {
        $this->fields['N'] = $this->joinComponents([$lastName, $firstName]);
        $this->fields['FN'] = $this->escapeText($firstName . ' ' . $lastName);

        return $this;
    }

    /**
     * Add an email address
     */
    public function addEmail(string $email): self
    {
        return $this->setText('EMAIL', $email);
    }

    /**
     * Add a phone number
     */
    public function addPhone(string $phone): self
    {
        return $this->setText('TEL', $phone);
    }

    /**
     * Add a postal address
     */
    public function addAddress(string $street, string $city, string $state, string $zip, string $country): self
    {
        $this->fields['ADR'] = ';;' . $this->joinComponents([$street, $city, $state, $zip, $country]);

        return $this;
    }

    /**
     * Add organization and optional unit/department
     */
    public function addOrganization(string $organization, ?string $unit = null): self
    {
        $this->fields['ORG'] = $unit === null || $unit === ''
            ? $this->escapeText($organization)
            : $this->joinComponents([$organization, $unit]);

        return $this;
    }

    /**
     * Add a job title
     */
    public function addTitle(string $title): self
    {
        return $this->setText('TITLE', $title);
    }

    /**
     * Add a URL (website)
     */
    public function addUrl(string $url): self
    {
        return $this->setUri('URL', $url);
    }

    /**
     * Add a note or description
     */
    public function addNote(string $note): self
    {
        return $this->setText('NOTE', $note);
    }

    /**
     * Add a birthday (YYYY-MM-DD)
     */
    public function addBirthday(string $date): self
    {
        return $this->setText('BDAY', $date);
    }

    /**
     * Add a photo URL
     */
    public function addPhoto(string $url): self
    {
        return $this->setUri('PHOTO', $url);
    }

    /**
     * Add a custom vCard field
     *
     * @param string $key Field name (e.g. X-NICKNAME)
     * @param string $value Field value
     */
    public function addCustom(string $key, string $value): self
    {
        $name = strtoupper($key);
        if (preg_match('/^[A-Z0-9-]+$/', $name) !== 1) {
            throw new \InvalidArgumentException('The vCard property name is not a valid token.');
        }

        return $this->setText($name, $value);
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
            $lines[] = $this->foldLine($key . ':' . $value);
        }
        $lines[] = 'END:VCARD';

        return implode("\r\n", $lines) . "\r\n";
    }

    /**
     * Save the vCard to a file
     */
    public function saveToFile(string $filename): void
    {
        if ($filename === '' || str_contains($filename, "\0")) {
            throw new \InvalidArgumentException('The vCard filename is empty or contains a NUL byte.');
        }

        if (file_put_contents($filename, $this->toString()) === false) {
            throw new \RuntimeException('Unable to write the vCard file.');
        }
    }

    private function setText(string $name, string $value): self
    {
        $this->fields[$name] = $this->escapeText($value);

        return $this;
    }

    private function setUri(string $name, string $value): self
    {
        if (preg_match('/[\x00-\x1F\x7F]/', $value) === 1) {
            throw new \InvalidArgumentException('The vCard URI contains a control character.');
        }

        $this->fields[$name] = $value;

        return $this;
    }

    /**
     * Escape a vCard 3.0 TEXT value (RFC 2426).
     */
    private function escapeText(string $value): string
    {
        $value = str_replace('\\', '\\\\', $value);
        $value = str_replace(',', '\\,', $value);
        $value = str_replace(';', '\\;', $value);

        return str_replace(["\r\n", "\r", "\n"], '\\n', $value);
    }

    /**
     * @param list<string> $parts
     */
    private function joinComponents(array $parts): string
    {
        return implode(';', array_map($this->escapeText(...), $parts));
    }

    /**
     * Fold a content line at 75 octets without splitting a UTF-8 character.
     */
    private function foldLine(string $line): string
    {
        if (strlen($line) <= 75) {
            return $line;
        }

        $parts = [];
        $offset = 0;
        $limit = 75;
        $length = strlen($line);

        while ($offset < $length) {
            $take = min($limit, $length - $offset);
            if ($offset + $take < $length) {
                while ($take > 0 && (ord($line[$offset + $take]) & 0xC0) === 0x80) {
                    --$take;
                }
                if ($take === 0) {
                    $take = 1;
                }
            }
            $parts[] = substr($line, $offset, $take);
            $offset += $take;
            $limit = 74;
        }

        return implode("\r\n ", $parts);
    }
}
