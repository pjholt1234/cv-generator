# Contributing to CV Generator

Thank you for considering contributing to CV Generator! This document explains how to set up the development environment and contribute to the project.

## Development Setup

1. **Fork and clone the repository:**
   ```bash
   git clone https://github.com/YOUR_USERNAME/cv-generator.git
   cd cv-generator
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Run tests locally:**
   ```bash
   composer test
   ```

## Continuous Integration

This project uses GitHub Actions for automated testing. Two workflows are configured:

### 1. Tests Workflow (`.github/workflows/tests.yml`)
- **Triggers:** Push to `main`, `master`, or `develop` branches, and pull requests
- **PHP Versions:** Tests on PHP 8.3 and 8.4
- **Features:**
  - Runs full PHPUnit test suite
  - Generates code coverage reports
  - Uploads coverage to Codecov (optional)
  - Caches Composer dependencies for faster builds

### 2. CI Workflow (`.github/workflows/ci.yml`)
- **Triggers:** Push to `main` or `master` branches, and pull requests
- **PHP Version:** PHP 8.3 only
- **Features:**
  - Quick test execution
  - Optional code style checking
  - Faster feedback for simple changes

## Setting Up GitHub Actions

When you push this code to GitHub, the workflows will automatically run. Here's what happens:

1. **On every push/PR:** Both workflows trigger
2. **Test execution:** PHPUnit runs all tests in the `tests/` directory
3. **Multiple PHP versions:** Tests run on PHP 8.3 and 8.4 (in tests.yml)
4. **Status badges:** Show pass/fail status in the README

## Workflow Configuration

### Required GitHub Secrets (Optional)
If you want to use Codecov for coverage reporting:
1. Sign up at [codecov.io](https://codecov.io)
2. Add your repository
3. Add `CODECOV_TOKEN` to your GitHub repository secrets

### Customizing Workflows

**To modify PHP versions tested:**
```yaml
strategy:
  matrix:
    php-version: ['8.3', '8.4', '8.5'] # Add more versions
```

**To change trigger branches:**
```yaml
on:
  push:
    branches: [ main, develop, feature/* ] # Add more patterns
```

**To add code quality tools:**
```bash
# Add to composer.json dev dependencies
composer require --dev squizlabs/php_codesniffer
composer require --dev phpstan/phpstan
```

## Local Development

### Running Tests
```bash
# Run all tests
composer test

# Run tests with coverage
./vendor/bin/phpunit --coverage-html coverage

# Run specific test
./vendor/bin/phpunit tests/CVGeneratorTest.php
```

### Code Style
```bash
# Check code style (if phpcs is installed)
vendor/bin/phpcs src tests --standard=PSR12

# Fix code style (if phpcbf is installed)
vendor/bin/phpcbf src tests --standard=PSR12
```

## Pull Request Process

1. **Create a feature branch:**
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. **Make your changes and add tests**

3. **Ensure tests pass locally:**
   ```bash
   composer test
   ```

4. **Commit your changes:**
   ```bash
   git commit -m "Add: your feature description"
   ```

5. **Push and create a pull request:**
   ```bash
   git push origin feature/your-feature-name
   ```

6. **GitHub Actions will automatically:**
   - Run tests on multiple PHP versions
   - Check code quality
   - Report results on your PR

## Test Requirements

- All new features must include tests
- Tests must pass on all supported PHP versions
- Aim for high code coverage
- Follow existing test patterns

## Debugging Failed Tests

If tests fail in GitHub Actions:

1. **Check the Actions tab** in your GitHub repository
2. **Click on the failed workflow** to see detailed logs
3. **Look for specific error messages** in the test output
4. **Run the same test locally** to reproduce the issue

## Example Test Addition

```php
public function testNewFeature(): void
{
    // Arrange
    $cvData = new CVData();
    $cvData->setPersonalInfo('Test', 'User', '123 St', '555-1234', 'test@example.com');
    
    // Act
    $result = $cvData->newMethod();
    
    // Assert
    $this->assertEquals('expected', $result);
}
```

## Questions?

If you have questions about the CI/CD setup or contributing:
- Open an issue on GitHub
- Check existing issues for similar questions
- Review the workflow files for configuration details 