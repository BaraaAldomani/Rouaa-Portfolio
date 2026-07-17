<?php

namespace App\Filament\Pages;

use App\Support\SettingsDefaults;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class IdentitySettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static ?string $navigationLabel = 'Identity';

    protected static ?string $title = 'Identity';

    protected static ?int $navigationSort = 2;

    public static function group(): string
    {
        return 'identity';
    }

    public static function defaultValues(): array
    {
        return SettingsDefaults::identity();
    }

    protected function formSchema(): array
    {
        return [
            Section::make('Name & tagline')
                ->columns(2)
                ->schema([
                    TextInput::make('name_ar')->label('Name (Arabic)')->required(),
                    TextInput::make('name_en')->label('Name (English)')->required(),
                    TextInput::make('eyebrow_ar')->label('Eyebrow (Arabic)'),
                    TextInput::make('eyebrow_en')->label('Eyebrow (English)'),
                    TextInput::make('tagline_ar')->label('Tagline (Arabic)'),
                    TextInput::make('tagline_en')->label('Tagline (English)'),
                ]),
            Section::make('Hero call-to-action buttons')
                ->columns(2)
                ->schema([
                    TextInput::make('cta_primary_ar')->label('Primary button (Arabic)'),
                    TextInput::make('cta_primary_en')->label('Primary button (English)'),
                    TextInput::make('cta_secondary_ar')->label('Secondary button (Arabic)'),
                    TextInput::make('cta_secondary_en')->label('Secondary button (English)'),
                ]),
        ];
    }
}
