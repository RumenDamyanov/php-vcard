# Contributing to php-vcard

Thank you for considering contributing to php-vcard! We welcome contributions from everyone.

## Development Setup

1. Fork the repository
2. Clone your fork: `git clone https://github.com/your-username/php-vcard.git`
3. Install dependencies: `composer install`
4. Create a new branch: `git checkout -b feature/your-feature-name`

## Running Tests

```bash
# Run all tests
composer test

# Run tests with coverage
composer test-coverage

# Run tests with minimum coverage requirement
composer test-coverage-min
```

## Code Quality

We maintain high code quality standards:

- **100% test coverage** - All new code must be covered by tests
- **PSR-12 coding standards** - Use `composer format` to format your code
- **Static analysis** - Use `composer analyse` to check your code
- **Comprehensive documentation** - Add docblocks to all public methods

## Submitting Changes

1. Ensure all tests pass: `composer ci`
2. Commit your changes with a descriptive message
3. Push to your fork: `git push origin feature/your-feature-name`
4. Create a Pull Request

## Pull Request Guidelines

- Include tests for any new functionality
- Update documentation if needed
- Ensure backward compatibility
- Follow the existing code style
- Write clear, descriptive commit messages

## Reporting Issues

- Use the [GitHub issue tracker](https://github.com/RumenDamyanov/php-vcard/issues)
- Include PHP version, Laravel/Symfony version (if applicable)
- Provide a minimal code example that reproduces the issue
- Include relevant error messages

## Code of Conduct

Be respectful and inclusive. We want everyone to feel welcome to contribute.

Thank you for contributing! 🎉
