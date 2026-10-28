# Security Policy

## Supported Versions

We actively support the following versions:

| Version | PHP  | Supported          |
| ------- | ---- | ------------------ |
| 1.1.x   | 8.3+ | :white_check_mark: |
| 1.0.x   | 8.2+ | :white_check_mark: until PHP 8.2 EOL (31 Dec 2026) |

Runtime PHP must be a patched build. PHP2Shell ([CVE-2026-109618](https://www.cve.org/CVERecord?id=CVE-2026-109618), [CVE-2026-109619](https://www.cve.org/CVERecord?id=CVE-2026-109619)) is in the PHP engine, not in this library. Upgrade the interpreter to **8.5.12+**, **8.4.27+**, **8.3.36+**, or **8.2.35+**. There is no application-level workaround; see the [PHP Foundation advisory](https://thephp.foundation/blog/2026/10/21/todays-php-security-release-and-how-were-strengthening-php-security/) and [CISA alert](https://www.cisa.gov/news-events/alerts/2026/10/21/critical-vulnerabilities-php-require-immediate-patching).

## Reporting a Vulnerability

If you discover a security vulnerability in php-vcard, please report it responsibly:

**DO NOT** create a public GitHub issue for security vulnerabilities.

Instead, please email: **contact@rumenx.com**

Include the following information:
- Description of the vulnerability
- Steps to reproduce the issue
- Potential impact
- Any suggested fixes (if available)

## Response Timeline

- **Acknowledgment**: Within 24-48 hours
- **Initial Assessment**: Within 5 business days
- **Status Updates**: Weekly updates until resolved
- **Resolution**: We aim to resolve critical issues within 30 days

## Disclosure Policy

- We will acknowledge receipt of your vulnerability report
- We will confirm the vulnerability and determine its severity
- We will release a fix as soon as possible
- We will publicly disclose the vulnerability after a fix is available

## Security Best Practices

When using php-vcard:
- Always validate and sanitize user input before creating vCards
- Use HTTPS when serving vCard files over the web
- Be cautious when allowing user-generated vCard content
- Keep your PHP version and dependencies up to date

Thank you for helping keep php-vcard secure! 🔒
