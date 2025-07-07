# CV Generator

[![Tests](https://github.com/pjholt1234/cv-generator/workflows/Tests/badge.svg)](https://github.com/pjholt1234/cv-generator/actions)
[![CI](https://github.com/pjholt1234/cv-generator/workflows/CI/badge.svg)](https://github.com/pjholt1234/cv-generator/actions)

A PHP 8.3+ Composer package for generating professional, technical-styled CV PDFs with a clean, structured layout.

## Features

- ✅ Clean, professional technical CV layout
- ✅ PDF generation using DomPDF
- ✅ Fluent API with CVData builder class
- ✅ Support for multiple experience entries with detailed references
- ✅ Education section with bullet points
- ✅ Flexible optional sections with subsections support
- ✅ LinkedIn profile integration
- ✅ Comprehensive PHPUnit test suite
- ✅ PHP 8.3+ compatibility

## Installation

Install via Composer:

```bash
composer require pj-holt/cv-generator
```

## Requirements

- PHP 8.3 or higher
- Composer

## Quick Start

```php
<?php

require_once 'vendor/autoload.php';

use CVGenerator\CVGenerator;
use CVGenerator\CVData;

// Create CV data using the fluent builder
$cvData = new CVData();
$cvData->setPersonalInfo(
    'John',
    'Doe',
    '123 Main Street, City, State 12345',
    '+1-555-123-4567',
    'john.doe@example.com',
    'https://linkedin.com/in/johndoe', // Optional LinkedIn
    'Full Stack Developer' // Optional title
)
->setIntroduction('Experienced software developer with 5+ years in web development.')
->addExperience(
    'Tech Company',
    'Senior Developer',
    'Jan 2020',
    'Present',
    [
        'Led development of microservices architecture',
        'Implemented CI/CD pipelines',
        'Mentored junior developers',
        'Collaborated with product teams'
    ],
    [   // Detailed reference information
        'name' => 'Jane Manager',
        'job_title' => 'Engineering Director',
        'company' => 'Tech Company',
        'email' => 'jane@company.com',
        'phone' => '+1-555-987-6543',     // Optional
        'relationship' => 'Direct Manager' // Optional
    ]
);

// Generate PDF
$generator = new CVGenerator();
$generator->generate($cvData->toArray(), 'my_cv.pdf');
```

## Optional Sections

The package supports flexible optional sections with various formats:

### Basic Optional Section

```php
$cvData->addOptionalSection(
    'Languages',
    [
        'English (Native)',
        'Spanish (Fluent)',
        'French (Intermediate)'
    ]
);
```

### Optional Section with Subtitle

```php
$cvData->addOptionalSection(
    'Certifications',
    [
        'AWS Certified Solutions Architect',
        'Certified Kubernetes Administrator'
    ],
    'Professional Development' // Optional subtitle
);
```

### Optional Section with Subsections

```php
$cvData->addOptionalSection(
    'Technical Skills',
    null, // No main bullets
    'Core Competencies', // Optional main subtitle
    [
        [
            'title' => 'Frontend Development',
            'subtitle' => 'Web Technologies', // Optional subsection subtitle
            'bullets' => [
                'HTML5/CSS3',
                'JavaScript/TypeScript',
                'React/Vue.js'
            ]
        ],
        [
            'title' => 'Backend Development',
            'bullets' => [
                'PHP/Laravel',
                'Node.js',
                'Python/Django'
            ]
        ]
    ]
);
```

## Experience References

Each experience entry can include detailed reference information:

```php
$cvData->addExperience(
    'Company Name',
    'Role',
    'Start Date',
    'End Date',
    ['Achievement 1', 'Achievement 2'],
    [
        'name' => 'Reference Name',
        'job_title' => 'Job Title',
        'company' => 'Company Name',
        'email' => 'reference@email.com',
        'phone' => '+1-555-123-4567',     // Optional
        'relationship' => 'Direct Manager' // Optional
    ]
);
```

## CV Layout

The generated CV follows this professional structure:

```
First name Last name
Title (if provided)
———————————
Address, Telephone, email, LinkedIn (optional)
———————————
Introduction text
———————————
Professional experience 

Company name 1            Date start - Date end
Role
- Bullet point 1
- Bullet point 2
- Bullet point 3
- Bullet point 4

Reference:
Name - Job Title
Company
Email / Phone
Relationship to candidate

Company name 2           Date start - Date end
Role
- Bullet point 1
- Bullet point 2
- Bullet point 3
- Bullet point 4
———————————
Education             Date start - Date end
Qualification
- Bullet point 1
- Bullet point 2
- Bullet point 3
- Bullet point 4
———————————
Optional section title
Optional section subtitle (if provided)
- Bullet point 1
- Bullet point 2
- Bullet point 3
- Bullet point 4

[OR with subsections]

Optional section title
Optional section subtitle
  Subsection 1 Title
  Subsection 1 Subtitle
  - Bullet point 1
  - Bullet point 2

  Subsection 2 Title
  - Bullet point 1
  - Bullet point 2
```

## API Reference

### CVData Class

The `CVData` class provides a fluent interface for building CV data:

#### `setPersonalInfo(string $firstName, string $lastName, string $address, string $telephone, string $email, ?string $linkedin = null, ?string $title = null): self`

Sets personal information for the CV header.

#### `setIntroduction(string $introduction): self`

Sets the introduction/summary text.

#### `addExperience(string $company, string $role, string $dateStart, string $dateEnd, array $bullets, ?array $reference = null): self`

Adds a professional experience entry.

#### `addEducation(string $institution, string $qualification, string $dateStart, string $dateEnd, array $bullets): self`

Adds an education entry.

#### `addOptionalSection(string $title, ?array $bullets = null, ?string $subtitle = null, ?array $subsections = null): self`

Adds an optional section (skills, certifications, etc.).

#### `toArray(): array`

Returns the CV data as an array for the generator.

### CVGenerator Class

#### `generate(array $data, string $outputPath): void`

Generates a PDF CV from the provided data array and saves it to the specified path.

## Usage Examples

### Using Raw Array Data

```php
$data = [
    'first_name' => 'Jane',
    'last_name' => 'Smith',
    'address' => '456 Oak Ave, City, State',
    'telephone' => '+1-555-987-6543',
    'email' => 'jane@example.com',
    'linkedin' => 'https://linkedin.com/in/janesmith',
    'introduction' => 'Senior software engineer...',
    'experience' => [
        [
            'company' => 'Tech Corp',
            'role' => 'Senior Engineer',
            'date_start' => 'Jan 2020',
            'date_end' => 'Present',
            'bullets' => [
                'Led development team',
                'Implemented new features',
                'Improved performance by 40%'
            ],
            'reference' => [
                'name' => 'John Manager',
                'job_title' => 'Engineering Director',
                'company' => 'Tech Corp',
                'email' => 'john@techcorp.com',
                'phone' => '+1-555-123-4567',
                'relationship' => 'Direct Manager'
            ]
        ]
    ],
    'education' => [
        [
            'institution' => 'University',
            'qualification' => 'BS Computer Science',
            'date_start' => 'Sep 2016',
            'date_end' => 'May 2020',
            'bullets' => [
                'Graduated Magna Cum Laude',
                'Relevant coursework in algorithms',
                'Senior capstone project'
            ]
        ]
    ],
    'optional' => [
        [
            'title' => 'Technical Skills',
            'bullets' => [
                'PHP, JavaScript, Python',
                'Laravel, React, Vue.js',
                'MySQL, PostgreSQL'
            ]
        ]
    ]
];

$generator = new CVGenerator();
$generator->generate($data, 'cv.pdf');
```

### Multiple Experience Entries

```php
$cvData = new CVData();
$cvData->setPersonalInfo('John', 'Doe', '123 St', '555-1234', 'john@example.com')
    ->addExperience('Company A', 'Developer', 'Jan 2020', 'Dec 2021', ['Bullet 1', 'Bullet 2'])
    ->addExperience('Company B', 'Senior Developer', 'Jan 2022', 'Present', ['Bullet 3', 'Bullet 4']);
```

### Optional Sections with Subtitles

```php
$cvData->addOptionalSection(
    'Certifications',
    [
        'AWS Certified Solutions Architect',
        'Certified Kubernetes Administrator'
    ],
    'Professional Development'
);
```

## Testing

Run the test suite:

```bash
composer test
```

Or run PHPUnit directly:

```bash
./vendor/bin/phpunit
```

The test suite includes:
- PDF generation tests
- Data validation tests
- Special character handling
- Empty data handling
- CVData builder functionality

## Development

### Running Tests

```bash
# Install dependencies
composer install

# Run tests
composer test

# Run tests with coverage (if xdebug is installed)
./vendor/bin/phpunit --coverage-html coverage
```

### Code Style

This package follows PSR-12 coding standards.

## License

This package is open-sourced software licensed under the MIT license.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Changelog

### 1.0.0
- Initial release
- Basic CV generation functionality
- CVData builder class
- Comprehensive test suite 
