# php-vcard

[![Build Status](https://github.com/RumenDamyanov/php-vcard/actions/workflows/tests.yml/badge.svg)](https://github.com/RumenDamyanov/php-vcard/actions)
[![codecov](https://codecov.io/gh/RumenDamyanov/php-vcard/graph/badge.svg?token=WKgaDnpzJC)](https://codecov.io/gh/RumenDamyanov/php-vcard)

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
use Rumenx\PhpVcard\VCard;

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

Route::get('/vcard', function () {
    $vcard = new VCard();
    $vcard->addName('Arya', 'Stark');
    $vcard->addEmail('arya@example.com');
    $vcard->addPhone('+1987654321');

    return response($vcard->toString(), 200, [
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

## Framework Integration

This package follows a **simple, framework-agnostic approach** by design. Unlike packages that require special adapters, service providers, or complex integrations, php-vcard works out-of-the-box with any PHP framework or plain PHP project.

**Why no special adapters?**
- **Simplicity**: Just instantiate `new VCard()` - no magic, no hidden complexity
- **Universal compatibility**: Works with Laravel, Symfony, CodeIgniter, or any PHP framework
- **Easy debugging**: No framework-specific layers to troubleshoot
- **Minimal maintenance**: No need to maintain separate adapters for different frameworks
- **Standard PHP**: Uses only basic PHP features (strings, arrays, file operations)

This approach makes the package more reliable, easier to understand, and ensures it will continue working across different framework versions without requiring updates.

## Testing

```bash
# Run tests
composer test

# Run tests with coverage
composer test-coverage

# Generate HTML coverage report
composer test-coverage-html
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details on how to contribute to this project.

## Security

For security vulnerabilities, please see our [Security Policy](SECURITY.md).

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for release history and changes.

## Support

If you find this package useful, please consider:
- ⭐ Starring the repository
- 💖 [Sponsoring the project](FUNDING.md)
- 🐛 Reporting issues
- 📖 Contributing to documentation

## License

This project is licensed under the [MIT License](LICENSE.md).
