# php-vcard

[![Build Status](https://github.com/RumenDamyanov/php-vcard/actions/workflows/tests.yml/badge.svg)](https://github.com/RumenDamyanov/php-vcard/actions)
[![codecov](https://codecov.io/gh/RumenDamyanov/php-vcard/branch/main/graph/badge.svg)](https://codecov.io/gh/RumenDamyanov/php-vcard)

A framework-agnostic PHP package to generate vCard files (compatible with iPhone, Android, Gmail, iCloud, etc.), with out-of-the-box support for Laravel and Symfony.

## Features

- Generate vCard files as static files or HTTP responses
- Compatible with major contact managers (iOS, Android, Gmail, iCloud, etc.)
- Simple, extensible API
- 100% test coverage with Pest
- MIT License

## Installation

```bash
composer require rumenx/php-vcard
```

## Usage

### Basic Usage

```php
use rumenx\VCard\VCard;

$vcard = new VCard();
$vcard->addName('Jon', 'Snow');
$vcard->addEmail('jon@example.com');
$vcard->addPhone('+1234567890');
$vcard->addAddress('123 Main St', 'City', 'State', '12345', 'Country');

// Save to file
$vcard->saveToFile('jon_snow.vcf');

// Or get as string
$content = $vcard->toString();
```

### Laravel Example

```php
use Rumenx\PhpVcard\VCard;

// Option 1: Dependency Injection (recommended)
Route::get('/vcard', function (VCard $vcard) {
    $vcard->addName('Arya', 'Stark');
    $vcard->addEmail('arya@example.com');
    $vcard->addPhone('+1987654321');
    return response($vcard->toString(), 200, [
        'Content-Type' => 'text/vcard',
        'Content-Disposition' => 'attachment; filename="arya_stark.vcf"',
    ]);
});

// Option 2: Facade
use VCard;

Route::get('/vcard-facade', function () {
    VCard::addName('Arya', 'Stark');
    VCard::addEmail('arya@example.com');
    VCard::addPhone('+1987654321');
    return response(VCard::toString(), 200, [
        'Content-Type' => 'text/vcard',
        'Content-Disposition' => 'attachment; filename="arya_stark.vcf"',
    ]);
});
```

### Symfony Example

```php
use Rumenx\PhpVcard\VCard;
use Symfony\Component\HttpFoundation\Response;

// ...
$vcard = new VCard();
$vcard->addName('Alice', 'Brown');
$vcard->addEmail('alice@example.com');
$vcard->addPhone('+1122334455');
$response = new Response(
    $vcard->toString(),
    200,
    [
        'Content-Type' => 'text/vcard',
        'Content-Disposition' => 'attachment; filename="alice_brown.vcf"',
    ]
);
```

## Testing

```bash
./vendor/bin/pest --coverage
```

## License

MIT

---

**Author:** Rumen Damyanov (<contact@rumenx.com>)

[GitHub Repository](https://github.com/RumenDamyanov/php-vcard)
