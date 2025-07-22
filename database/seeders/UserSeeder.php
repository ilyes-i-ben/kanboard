<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->createAdminUser();
        $this->createTeamMembers();
    }

    private function createAdminUser(): User
    {
        return User::create([
            'name' => 'ilyes',
            'email' => 'bilyesc+dev@gmail.com',
            'password' => '$2y$12$Py2IpIzTAa2Ji/.ZHPUYJ.6AAhwuSGfR4/jC4siEfn6.Y0WOhC2t6',
            'email_verified_at' => now(),
            'created_at' => now()->subMonths(6),
            'updated_at' => now(),
        ]);
    }

    private function createTeamMembers(): void
    {
        $teamMembers = [
            ['name' => 'Sarah Johnson', 'email' => 'sarah.johnson@kanboard.com'],
            ['name' => 'Mike Chen', 'email' => 'mike.chen@kanboard.com'],
            ['name' => 'Emma Rodriguez', 'email' => 'emma.rodriguez@kanboard.com'],
            ['name' => 'David Kim', 'email' => 'david.kim@kanboard.com'],
            ['name' => 'Lisa Zhang', 'email' => 'lisa.zhang@kanboard.com'],
            ['name' => 'Alex Thompson', 'email' => 'alex.thompson@kanboard.com'],
            ['name' => 'Priya Patel', 'email' => 'priya.patel@kanboard.com'],
            ['name' => 'James Wilson', 'email' => 'james.wilson@kanboard.com'],
            ['name' => 'Maria Garcia', 'email' => 'maria.garcia@kanboard.com'],
            ['name' => 'Tom Anderson', 'email' => 'tom.anderson@kanboard.com'],
        ];

        foreach ($teamMembers as $member) {
            User::create([
                'name' => $member['name'],
                'email' => $member['email'],
                'password' => '$2y$12$Py2IpIzTAa2Ji/.ZHPUYJ.6AAhwuSGfR4/jC4siEfn6.Y0WOhC2t6',
                'email_verified_at' => now(),
                'created_at' => fake()->dateTimeBetween('-4 months', '-1 week'),
                'updated_at' => now(),
            ]);
        }
    }
}
