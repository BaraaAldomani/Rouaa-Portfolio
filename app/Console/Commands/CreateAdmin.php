<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'app:create-admin
        {--email= : Admin email (falls back to ADMIN_EMAIL)}
        {--password= : Admin password (falls back to ADMIN_PASSWORD)}
        {--name= : Display name (falls back to ADMIN_NAME or "Admin")}';

    protected $description = 'Create or update the admin user that can access the Filament panel.';

    public function handle(): int
    {
        $email = $this->option('email') ?: env('ADMIN_EMAIL');
        $password = $this->option('password') ?: env('ADMIN_PASSWORD');
        $name = $this->option('name') ?: env('ADMIN_NAME', 'Admin');

        if (! $email || ! $password) {
            $this->error('Provide --email and --password (or set ADMIN_EMAIL / ADMIN_PASSWORD in .env).');

            return self::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($password), 'is_admin' => true],
        );

        $this->info("Admin ready: {$user->email} (can access /admin).");

        return self::SUCCESS;
    }
}
