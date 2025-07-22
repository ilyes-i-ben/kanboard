<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Board::withoutEvents(function () {
            $this->call([
                UserSeeder::class,
                BoardSeeder::class,
            ]);
        });
    }
}
