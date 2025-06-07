<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Rumenx\PhpVcard\VCard;

describe('VCard', function () {
    it('generates a valid vCard string', function () {
        $vcard = (new VCard())
            ->addName('John', 'Doe')
            ->addEmail('john@example.com')
            ->addPhone('+1234567890')
            ->addAddress('123 Main St', 'City', 'State', '12345', 'Country');

        $content = $vcard->toString();
        expect($content)->toContain('BEGIN:VCARD');
        expect($content)->toContain('END:VCARD');
        expect($content)->toContain('FN:John Doe');
        expect($content)->toContain('EMAIL:john@example.com');
        expect($content)->toContain('TEL:+1234567890');
        expect($content)->toContain('ADR:;;123 Main St;City;State;12345;Country');
    });

    it('saves vCard to file', function () {
        $vcard = (new VCard())
            ->addName('Jane', 'Smith')
            ->addEmail('jane@example.com');
        $file = __DIR__ . '/test.vcf';
        $vcard->saveToFile($file);
        expect(file_exists($file))->toBeTrue();
        $content = file_get_contents($file);
        expect($content)->toContain('FN:Jane Smith');
        unlink($file);
    });

    it('supports advanced vCard fields', function () {
        $vcard = (new VCard())
            ->addName('Tyrion', 'Lannister')
            ->addOrganization('House Lannister', 'Casterly Rock')
            ->addTitle('Hand of the Queen')
            ->addUrl('https://got.example.com')
            ->addNote('A mind needs books as a sword needs a whetstone.')
            ->addBirthday('1978-06-11')
            ->addPhoto('https://got.example.com/tyrion.jpg')
            ->addCustom('X-NICKNAME', 'The Imp');
        $content = $vcard->toString();
        expect($content)->toContain('ORG:House Lannister;Casterly Rock');
        expect($content)->toContain('TITLE:Hand of the Queen');
        expect($content)->toContain('URL:https://got.example.com');
        expect($content)->toContain('NOTE:A mind needs books as a sword needs a whetstone.');
        expect($content)->toContain('BDAY:1978-06-11');
        expect($content)->toContain('PHOTO:https://got.example.com/tyrion.jpg');
        expect($content)->toContain('X-NICKNAME:The Imp');
    });
});
