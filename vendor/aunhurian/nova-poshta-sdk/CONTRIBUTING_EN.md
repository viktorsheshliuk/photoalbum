# Contributing to Nova Poshta SDK

Thank you for your interest in contributing to Nova Poshta SDK! This document provides guidelines and instructions for contributing to this project.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How Can I Contribute?](#how-can-i-contribute)
- [Setting Up Development Environment](#setting-up-development-environment)
- [Code Style Guidelines](#code-style-guidelines)
- [Testing Guidelines](#testing-guidelines)
- [Submitting Changes](#submitting-changes)
- [Pull Request Process](#pull-request-process)

## Code of Conduct

By participating in this project, you are expected to uphold our [Code of Conduct](CODE_OF_CONDUCT.md).

## How Can I Contribute?

There are many ways you can contribute to the Nova Poshta SDK:

- **Report bugs**: If you find a bug, please submit an issue describing the problem, including steps to reproduce it.
- **Suggest features**: If you have an idea for a new feature or an improvement, open an issue to discuss it.
- **Improve documentation**: Help make our documentation clearer and more comprehensive.
- **Submit code changes**: Fix bugs, add features, or improve existing functionality through pull requests.

## Setting Up Development Environment

1. **Fork the repository**: Click the "Fork" button at the top of the repository page.

2. **Clone your fork**:
   ```bash
   git clone https://github.com/YOUR_USERNAME/nova-poshta-sdk.git
   cd nova-poshta-sdk
   ```

3. **Install dependencies**:
   ```bash
   composer install
   ```

4. **Set up testing environment**:
   ```bash
   composer install --dev
   ```

5. **Create a branch for your changes**:
   ```bash
   git checkout -b feature/your-feature-name
   ```

## Code Style Guidelines

This project follows the PSR-12 coding standard and PSR-4 autoloading standard.

- All PHP files must use the `declare(strict_types=1)` directive.
- Class names must be declared in `PascalCase`.
- Method names must be declared in `camelCase`.
- All PHP files should end with a single empty line.
- Use meaningful variable names that describe their purpose.
- Document code thoroughly with PHPDoc comments.

To check your code style, run:
```bash
vendor/bin/phpcs
```

## Testing Guidelines

All new features and bug fixes should include tests. Tests should be:

- **Comprehensive**: Cover all use cases and edge cases.
- **Isolated**: Each test should test only one specific functionality.
- **Fast**: Tests should run quickly for a smooth development experience.

This project uses PHPUnit for testing. To run the tests:

```bash
vendor/bin/phpunit
```

## Submitting Changes

1. **Make your changes**: Implement your feature or bug fix.
2. **Add tests**: Write tests to cover your changes.
3. **Update documentation**: Update any relevant documentation.
4. **Run tests**: Make sure all tests pass.
5. **Commit your changes**:
   ```bash
   git add .
   git commit -m "Brief description of your changes"
   ```
6. **Push to your fork**:
   ```bash
   git push origin feature/your-feature-name
   ```
7. **Submit a pull request**: Go to your fork on GitHub and click the "New pull request" button.

## Pull Request Process

1. **Describe your changes**: Provide a detailed description of what your PR does, and why it's needed.
2. **Reference related issues**: If your PR fixes an issue, reference it using `Fixes #issue_number`.
3. **Review**: Your PR will be reviewed by maintainers, who may suggest changes.
4. **Updates**: Make any necessary updates based on review feedback.
5. **Merge**: Once approved, a maintainer will merge your PR.

Thank you for contributing to Nova Poshta SDK! 