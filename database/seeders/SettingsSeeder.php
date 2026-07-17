<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Support\SettingsDefaults;
use Illuminate\Database\Seeder;

/**
 * Seeds the settings table from SettingsDefaults — the same source the Filament
 * settings pages read their defaults from. updateOrCreate keeps existing
 * dashboard edits intact on reseed (only missing keys are (re)created).
 */
class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (SettingsDefaults::all() as $group => $values) {
            foreach ($values as $key => $value) {
                Setting::updateOrCreate(
                    ['group' => $group, 'key' => $key],
                    ['value' => $value],
                );
            }
        }
    }
}
