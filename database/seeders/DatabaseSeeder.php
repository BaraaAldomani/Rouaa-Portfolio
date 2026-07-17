<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            TrainingSeeder::class,
            ExperienceSeeder::class,
            EducationSeeder::class,
            SkillSeeder::class,
            StatSeeder::class,
            SettingsSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
