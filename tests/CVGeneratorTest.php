<?php

namespace CVGenerator\Tests;

use CVGenerator\CVGenerator;
use CVGenerator\CVData;
use PHPUnit\Framework\TestCase;

class CVGeneratorTest extends TestCase
{
    private CVGenerator $generator;
    private string $tempDir;

    protected function setUp(): void
    {
        $this->generator = new CVGenerator();
        $this->tempDir = sys_get_temp_dir() . '/cv-generator-tests';
        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0777, true);
        }
    }

    protected function tearDown(): void
    {
        // Clean up test files
        $files = glob($this->tempDir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        if (is_dir($this->tempDir)) {
            rmdir($this->tempDir);
        }
    }

    public function testGenerateBasicCV(): void
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'address' => '123 Main St',
            'telephone' => '+1234567890',
            'email' => 'john.doe@example.com',
            'introduction' => 'Experienced software developer with 5+ years in web development.'
        ];

        $outputPath = $this->tempDir . '/basic_cv.pdf';
        $this->generator->generate($data, $outputPath);

        $this->assertFileExists($outputPath);
        $this->assertGreaterThan(0, filesize($outputPath));
        
        // Check if it's a valid PDF by checking the header
        $content = file_get_contents($outputPath);
        $this->assertStringStartsWith('%PDF', $content);
    }

    public function testGenerateCompleteCV(): void
    {
        $cvData = new CVData();
        $cvData->setPersonalInfo(
            'Jane',
            'Smith',
            '456 Oak Avenue, City, State 12345',
            '+1-555-123-4567',
            'jane.smith@example.com',
            'https://linkedin.com/in/janesmith'
        )
        ->setIntroduction('Senior software engineer with expertise in PHP, JavaScript, and cloud technologies. Passionate about building scalable web applications and leading development teams.')
        ->addExperience(
            'Tech Corp',
            'Senior Software Engineer',
            'Jan 2020',
            'Present',
            [
                'Led development of microservices architecture serving 1M+ users',
                'Implemented CI/CD pipelines reducing deployment time by 60%',
                'Mentored junior developers and conducted code reviews',
                'Collaborated with product team to define technical requirements'
            ],
            'John Manager - john.manager@techcorp.com'
        )
        ->addExperience(
            'StartupXYZ',
            'Full Stack Developer',
            'Jun 2018',
            'Dec 2019',
            [
                'Built responsive web applications using React and PHP',
                'Designed and implemented RESTful APIs',
                'Optimized database queries improving performance by 40%',
                'Participated in agile development processes'
            ]
        )
        ->addEducation(
            'University of Technology',
            'Bachelor of Science in Computer Science',
            'Sep 2014',
            'May 2018',
            [
                'Graduated Magna Cum Laude with 3.8 GPA',
                'Relevant coursework: Data Structures, Algorithms, Database Systems',
                'Senior project: E-commerce platform with payment integration',
                'Member of Computer Science Student Association'
            ]
        )
        ->addOptionalSection(
            'Technical Skills',
            [
                'Programming Languages: PHP, JavaScript, Python, Java',
                'Frameworks: Laravel, React, Vue.js, Express.js',
                'Databases: MySQL, PostgreSQL, MongoDB, Redis',
                'Tools: Docker, AWS, Git, Jenkins, Kubernetes'
            ]
        )
        ->addOptionalSection(
            'Certifications',
            [
                'AWS Certified Solutions Architect',
                'Certified Kubernetes Administrator',
                'PHP Zend Certified Engineer'
            ],
            'Professional Development'
        );

        $outputPath = $this->tempDir . '/complete_cv.pdf';
        $this->generator->generate($cvData->toArray(), $outputPath);

        $this->assertFileExists($outputPath);
        $this->assertGreaterThan(1000, filesize($outputPath)); // Should be substantial size
        
        // Check if it's a valid PDF
        $content = file_get_contents($outputPath);
        $this->assertStringStartsWith('%PDF', $content);
    }

    public function testGenerateWithEmptyData(): void
    {
        $data = [];
        $outputPath = $this->tempDir . '/empty_cv.pdf';
        
        $this->generator->generate($data, $outputPath);
        
        $this->assertFileExists($outputPath);
        $content = file_get_contents($outputPath);
        $this->assertStringStartsWith('%PDF', $content);
    }

    public function testGenerateWithSpecialCharacters(): void
    {
        $data = [
            'first_name' => 'José',
            'last_name' => 'García-López',
            'address' => '123 Café Street, São Paulo',
            'telephone' => '+55 11 99999-9999',
            'email' => 'jose.garcia@example.com',
            'introduction' => 'Développeur expérimenté avec expertise en technologies web & mobile.'
        ];

        $outputPath = $this->tempDir . '/special_chars_cv.pdf';
        $this->generator->generate($data, $outputPath);

        $this->assertFileExists($outputPath);
        $content = file_get_contents($outputPath);
        $this->assertStringStartsWith('%PDF', $content);
    }

    public function testCVDataBuilder(): void
    {
        $cvData = new CVData();
        $result = $cvData->setPersonalInfo(
            'Test',
            'User',
            '123 Test St',
            '555-1234',
            'test@example.com'
        );

        $this->assertInstanceOf(CVData::class, $result);
        
        $data = $cvData->toArray();
        $this->assertEquals('Test', $data['first_name']);
        $this->assertEquals('User', $data['last_name']);
        $this->assertEquals('test@example.com', $data['email']);
    }

    public function testCVDataWithLinkedIn(): void
    {
        $cvData = new CVData();
        $cvData->setPersonalInfo(
            'Test',
            'User',
            '123 Test St',
            '555-1234',
            'test@example.com',
            'https://linkedin.com/in/testuser'
        );

        $data = $cvData->toArray();
        $this->assertEquals('https://linkedin.com/in/testuser', $data['linkedin']);
    }

    public function testAddMultipleExperiences(): void
    {
        $cvData = new CVData();
        $cvData->addExperience(
            'Company A',
            'Developer',
            'Jan 2020',
            'Dec 2020',
            ['Bullet 1', 'Bullet 2']
        )
        ->addExperience(
            'Company B',
            'Senior Developer',
            'Jan 2021',
            'Present',
            ['Bullet 3', 'Bullet 4'],
            'Reference Person'
        );

        $data = $cvData->toArray();
        $this->assertCount(2, $data['experience']);
        $this->assertEquals('Company A', $data['experience'][0]['company']);
        $this->assertEquals('Company B', $data['experience'][1]['company']);
        $this->assertEquals('Reference Person', $data['experience'][1]['reference']);
    }

    public function testCVDataWithTitle(): void
    {
        $cvData = new CVData();
        $cvData->setPersonalInfo(
            'Test',
            'User',
            '123 Test St',
            '555-1234',
            'test@example.com',
            null,
            'Full Stack Developer'
        );

        $data = $cvData->toArray();
        $this->assertEquals('Full Stack Developer', $data['title']);
    }
} 