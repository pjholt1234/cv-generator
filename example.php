<?php

require_once 'vendor/autoload.php';

use CVGenerator\CVGenerator;
use CVGenerator\CVData;

// Example 1: Using the CVData builder class (recommended)
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

// Generate the CV
$generator = new CVGenerator();
$generator->generate($cvData->toArray(), 'jane_smith_cv.pdf');

echo "CV generated successfully: jane_smith_cv.pdf\n";

// Example 2: Using raw array data
$rawData = [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'address' => '123 Main Street, Anytown, ST 12345',
    'telephone' => '+1-555-987-6543',
    'email' => 'john.doe@example.com',
    'linkedin' => 'https://linkedin.com/in/johndoe',
    'introduction' => 'Experienced web developer with a passion for creating efficient, scalable solutions.',
    'experience' => [
        [
            'company' => 'Web Solutions Inc',
            'role' => 'Lead Developer',
            'date_start' => 'Mar 2021',
            'date_end' => 'Present',
            'bullets' => [
                'Architected and developed enterprise web applications',
                'Led a team of 5 developers using Agile methodologies',
                'Reduced application load times by 45% through optimization',
                'Implemented automated testing reducing bugs by 30%'
            ],
            'reference' => 'Sarah Johnson - sarah.johnson@websolutions.com'
        ],
        [
            'company' => 'Digital Agency',
            'role' => 'Frontend Developer',
            'date_start' => 'Jan 2019',
            'date_end' => 'Feb 2021',
            'bullets' => [
                'Developed responsive websites for 50+ clients',
                'Collaborated with designers to implement pixel-perfect UIs',
                'Optimized websites for SEO and performance',
                'Maintained and updated legacy codebases'
            ]
        ]
    ],
    'education' => [
        [
            'institution' => 'State University',
            'qualification' => 'Bachelor of Science in Computer Science',
            'date_start' => 'Aug 2015',
            'date_end' => 'May 2019',
            'bullets' => [
                'Graduated Summa Cum Laude with 3.9 GPA',
                'Dean\'s List for 6 consecutive semesters',
                'Capstone project: Machine learning recommendation system',
                'President of Programming Club'
            ]
        ]
    ],
    'optional' => [
        [
            'title' => 'Skills',
            'bullets' => [
                'Frontend: HTML5, CSS3, JavaScript, React, Vue.js',
                'Backend: PHP, Node.js, Python, Laravel, Express',
                'Database: MySQL, PostgreSQL, MongoDB',
                'DevOps: Docker, AWS, CI/CD, Git'
            ]
        ],
        [
            'title' => 'Awards',
            'subtitle' => 'Recognition',
            'bullets' => [
                'Employee of the Year 2022 - Web Solutions Inc',
                'Best Innovation Award 2021 - Digital Agency',
                'Hackathon Winner - State University 2018'
            ]
        ]
    ]
];

$generator->generate($rawData, 'john_doe_cv.pdf');

echo "CV generated successfully: john_doe_cv.pdf\n"; 