<?php

// Unit tests for the VCard class.
// These tests verify vCard generation, file saving, and advanced field support.

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

    it('escapes text so a field cannot inject another property', function () {
        $vcard = (new VCard())
            ->addName('Anne, Marie', 'Smith; Jr')
            ->addTitle('A\\B')
            ->addNote("hello\r\nEMAIL:evil@example.com")
            ->addEmail("a\nb@example.com")
            ->addPhone("1\r2")
            ->addBirthday("1978-06-11\nNOTE:x")
            ->addOrganization('House, Lannister')
            ->addAddress('12; Main', 'City, Name', 'State', '12345', 'Country');

        $content = $vcard->toString();

        expect($content)->toContain('N:Smith\\; Jr;Anne\\, Marie');
        expect($content)->toContain('FN:Anne\\, Marie Smith\\; Jr');
        expect($content)->toContain('TITLE:A\\\\B');
        expect($content)->toContain('NOTE:hello\\nEMAIL:evil@example.com');
        expect($content)->toContain('EMAIL:a\\nb@example.com');
        expect($content)->toContain('TEL:1\\n2');
        expect($content)->toContain('BDAY:1978-06-11\\nNOTE:x');
        expect($content)->toContain('ORG:House\\, Lannister');
        expect($content)->toContain('ADR:;;12\\; Main;City\\, Name;State;12345;Country');
        expect($content)->not->toMatch('/\r\nEMAIL:evil@example.com/');
    });

    it('rejects a property name or URI that could break the card', function () {
        $vcard = new VCard();

        expect(fn () => $vcard->addCustom("X-FOO\nBAR", 'x'))
            ->toThrow(\InvalidArgumentException::class);
        expect(fn () => $vcard->addCustom('', 'x'))
            ->toThrow(\InvalidArgumentException::class);
        expect(fn () => $vcard->addUrl("https://example.com\r\nEMAIL:evil@example.com"))
            ->toThrow(\InvalidArgumentException::class);
        expect(fn () => $vcard->addPhoto("https://example.com\nphoto.jpg"))
            ->toThrow(\InvalidArgumentException::class);
    });

    it('rejects a filename that is empty, contains NUL, or cannot be written', function () {
        $vcard = (new VCard())->addName('Jane', 'Smith');

        expect(fn () => $vcard->saveToFile(''))
            ->toThrow(\InvalidArgumentException::class);
        expect(fn () => $vcard->saveToFile("card\0.vcf"))
            ->toThrow(\InvalidArgumentException::class);

        set_error_handler(static fn (int $severity, string $message): bool => true);
        try {
            expect(fn () => $vcard->saveToFile(__DIR__))
                ->toThrow(\RuntimeException::class);
        } finally {
            restore_error_handler();
        }
    });

    it('folds long lines on octet boundaries and keeps UTF-8 characters intact', function () {
        $note = str_repeat('a', 69) . 'é' . str_repeat('b', 40);
        $content = (new VCard())->addNote($note)->toString();
        $unfolded = preg_replace("/\r\n[ \t]/", '', $content);

        expect($content)->toContain("\r\n ");
        expect($unfolded)->toContain('NOTE:' . $note);

        $binary = (new VCard())->addNote(str_repeat("\x80", 80))->toString();
        $unfoldedBinary = preg_replace("/\r\n[ \t]/", '', $binary);
        expect($unfoldedBinary)->toContain('NOTE:' . str_repeat("\x80", 80));
    });
});
