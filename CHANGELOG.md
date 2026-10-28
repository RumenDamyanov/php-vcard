# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.1.0] - 2026-10-28

### Security

- Escape vCard 3.0 text values so a comma, semicolon, backslash, or newline cannot break out of its field or inject another property.
- Reject custom property names that are not a token, and reject URLs and photo URLs that contain control characters.
- Reject an empty filename or a filename that contains a NUL byte. `saveToFile()` throws when the file cannot be written.
- Document that PHP2Shell ([CVE-2026-109618](https://www.cve.org/CVERecord?id=CVE-2026-109618), [CVE-2026-109619](https://www.cve.org/CVERecord?id=CVE-2026-109619)) is in the PHP engine: this package cannot patch it. Run PHP **8.3.36+**, **8.4.27+**, or **8.5.12+** ([PHP Foundation advisory](https://thephp.foundation/blog/2026/10/21/todays-php-security-release-and-how-were-strengthening-php-security/), [CISA alert](https://www.cisa.gov/news-events/alerts/2026/10/21/critical-vulnerabilities-php-require-immediate-patching)).

### Changed

- Require PHP **^8.3**. PHP 8.2 reaches upstream end of life on 31 December 2026; stay on 1.0.x if you must remain on 8.2 (and use **8.2.35+** until then).
- Fold content lines at 75 octets without splitting a UTF-8 character.
- CI tests PHP 8.3, 8.4, and 8.5. Coverage is collected on 8.4 only. Dev tooling is Pest 4 and PHPUnit 12.
- Add a PSR-12 PHP-CS-Fixer config and run PHPStan and the style check in CI.

## [1.0.0] - TBD

### Added
- Initial stable release of php-vcard
- Complete vCard 3.0 support
- Laravel auto-discovery
- Framework-agnostic design
- MIT License

---

**Note**: This project follows [Semantic Versioning](https://semver.org/).
For upgrade instructions between versions, please check the relevant sections above.
