<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@suronbikes.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
            ]
        );
    }
}
