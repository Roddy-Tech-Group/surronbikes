<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateAdminCommand extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Create a new admin user';

    public function handle(): int
    {
        $name = text(
            label: 'Name',
            required: true,
        );

        $email = text(
            label: 'Email',
            required: true,
            validate: function (string $value) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return 'Please enter a valid email address.';
                }
                if (Admin::where('email', $value)->exists()) {
                    return 'An admin with this email already exists.';
                }
                return null;
            },
        );

        $password = password(
            label: 'Password',
            required: true,
            validate: function (string $value) {
                if (strlen($value) < 8) {
                    return 'Password must be at least 8 characters.';
                }
                return null;
            },
        );

        Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $this->info("Admin user [{$email}] created successfully.");

        return self::SUCCESS;
    }
}
