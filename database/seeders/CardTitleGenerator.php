<?php

namespace Database\Seeders;

class CardTitleGenerator
{
    public static function generate(string $category): string
    {
        $tasks = [
            'Marketing' => [
                'Create social media content calendar',
                'Design email newsletter template',
                'Analyze campaign performance metrics',
                'Plan influencer collaboration strategy',
                'Develop brand messaging guidelines',
                'Create promotional video content',
                'Launch Google Ads campaign',
                'Update website landing pages',
            ],
            'Development' => [
                'Implement user authentication system',
                'Optimize database query performance',
                'Create REST API endpoints',
                'Fix responsive design issues',
                'Add unit tests for core modules',
                'Integrate payment gateway',
                'Implement real-time notifications',
                'Refactor legacy codebase',
            ],
            'Design' => [
                'Create wireframes for new feature',
                'Design mobile app icons',
                'Update brand style guide',
                'Conduct user experience research',
                'Create interactive prototypes',
                'Design email template layouts',
                'Develop component library',
                'Create accessibility guidelines',
            ],
            'Business Development' => [
                'Research potential partnership opportunities',
                'Prepare investor pitch deck',
                'Analyze competitor strategies',
                'Develop pricing strategy',
                'Create partnership proposal',
                'Schedule client meetings',
                'Update business plan document',
                'Conduct market analysis',
            ],
            'Customer Support' => [
                'Update FAQ documentation',
                'Create support ticket workflow',
                'Train team on new features',
                'Implement chatbot responses',
                'Analyze customer feedback trends',
                'Create help center articles',
                'Develop onboarding guide',
                'Update support templates',
            ],
            'Quality Assurance' => [
                'Test new feature functionality',
                'Create automated test scripts',
                'Perform cross-browser testing',
                'Review security vulnerabilities',
                'Test mobile responsiveness',
                'Validate data migration',
                'Conduct performance testing',
                'Update testing documentation',
            ],
        ];

        $categoryTasks = $tasks[$category] ?? [
            'Complete project milestone',
            'Review team deliverables',
            'Update project documentation',
            'Schedule stakeholder meeting',
            'Prepare status report',
        ];

        return fake()->randomElement($categoryTasks);
    }

    public static function generatePersonal(string $category): string
    {
        $tasks = [
            'Personal' => [
                'Plan weekend trip',
                'Organize home office',
                'Update personal budget',
                'Call family members',
                'Schedule dentist appointment',
                'Clean out garage',
                'Plan birthday party',
            ],
            'Work' => [
                'Prepare quarterly review',
                'Update LinkedIn profile',
                'Schedule team one-on-ones',
                'Review project proposals',
                'Attend industry conference',
                'Update resume',
                'Plan team building event',
            ],
            'Learning' => [
                'Complete online course module',
                'Read industry whitepaper',
                'Practice new programming language',
                'Attend webinar on leadership',
                'Study for certification exam',
                'Watch tutorial videos',
                'Join professional community',
            ],
            'Health' => [
                'Schedule annual checkup',
                'Plan weekly workout routine',
                'Meal prep for the week',
                'Take daily vitamins',
                'Practice meditation',
                'Go for morning run',
                'Track daily water intake',
            ],
        ];

        $categoryTasks = $tasks[$category] ?? ['Complete task', 'Review progress'];
        return fake()->randomElement($categoryTasks);
    }
}
