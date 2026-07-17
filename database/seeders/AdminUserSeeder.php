<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Local convenience only: creates a default admin when ADMIN_EMAIL /
 * ADMIN_PASSWORD are not set. In production, run `php artisan app:create-admin`
 * with real credentials instead (this seeder is skipped when APP_ENV=production).
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            return;
        }

        $email = env('ADMIN_EMAIL', 'admin@rouaa.test');
        $password = env('ADMIN_PASSWORD', 'password');
        $name = env('ADMIN_NAME', 'Rouaa Mahmoud');

        User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($password), 'is_admin' => true],
        );
    }
}
