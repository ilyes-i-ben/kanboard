<?php

namespace Database\Seeders\Templates;

class BoardTemplates
{
    public static function getAll(): array
    {
        return [
            [
                'title' => 'Website Redesign Project',
                'description' => 'Complete overhaul of company website with modern design and improved UX',
                'color' => '#3498db',
                'categories' => ['Design', 'Development', 'Content Creation', 'Quality Assurance'],
                'lists' => [
                    ['title' => 'Backlog', 'is_terminal' => false],
                    ['title' => 'Design Phase', 'is_terminal' => false],
                    ['title' => 'Development', 'is_terminal' => false],
                    ['title' => 'Review & Testing', 'is_terminal' => false],
                    ['title' => 'Completed', 'is_terminal' => true],
                    ['title' => 'Cancelled', 'is_terminal' => false],
                ]
            ],
            [
                'title' => 'Q4 Marketing Campaign',
                'description' => 'Holiday season marketing push across all channels',
                'color' => '#e74c3c',
                'categories' => ['Marketing', 'Social Media', 'Analytics', 'Content Creation'],
                'lists' => [
                    ['title' => 'Ideas & Planning', 'is_terminal' => false],
                    ['title' => 'Content Creation', 'is_terminal' => false],
                    ['title' => 'Review & Approval', 'is_terminal' => false],
                    ['title' => 'Live Campaigns', 'is_terminal' => false],
                    ['title' => 'Completed', 'is_terminal' => true],
                ]
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'Native iOS and Android app for customer engagement',
                'color' => '#2ecc71',
                'categories' => ['Development', 'Design', 'Product Management', 'Quality Assurance'],
                'lists' => [
                    ['title' => 'Feature Backlog', 'is_terminal' => false],
                    ['title' => 'Sprint Planning', 'is_terminal' => false],
                    ['title' => 'In Development', 'is_terminal' => false],
                    ['title' => 'Code Review', 'is_terminal' => false],
                    ['title' => 'Testing', 'is_terminal' => false],
                    ['title' => 'Released', 'is_terminal' => true],
                ]
            ],
            [
                'title' => 'Customer Onboarding Optimization',
                'description' => 'Improve new customer experience and reduce churn',
                'color' => '#f39c12',
                'categories' => ['Customer Support', 'Operations', 'Analytics', 'Strategy'],
                'lists' => [
                    ['title' => 'Research & Analysis', 'is_terminal' => false],
                    ['title' => 'Process Design', 'is_terminal' => false],
                    ['title' => 'Implementation', 'is_terminal' => false],
                    ['title' => 'Testing & Feedback', 'is_terminal' => false],
                    ['title' => 'Deployed', 'is_terminal' => true],
                ]
            ],
            [
                'title' => 'Partnership Development',
                'description' => 'Strategic partnerships to expand market reach',
                'color' => '#9b59b6',
                'categories' => ['Business Development', 'Sales', 'Legal', 'Strategy'],
                'lists' => [
                    ['title' => 'Prospect Research', 'is_terminal' => false],
                    ['title' => 'Initial Contact', 'is_terminal' => false],
                    ['title' => 'Negotiations', 'is_terminal' => false],
                    ['title' => 'Legal Review', 'is_terminal' => false],
                    ['title' => 'Active Partnership', 'is_terminal' => true],
                    ['title' => 'Declined', 'is_terminal' => false],
                ]
            ]
        ];
    }
}
