<?php

namespace App\Filament\Pages;

use App\Support\SettingsDefaults;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class HomeSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Home';

    protected static ?string $title = 'Home page';

    protected static ?int $navigationSort = 3;

    public static function group(): string
    {
        return 'home';
    }

    public static function defaultValues(): array
    {
        return SettingsDefaults::home();
    }

    protected function formSchema(): array
    {
        return [
            Section::make('Services strip')
                ->columns(2)
                ->schema([
                    TextInput::make('strip_tag_ar')->label('Eyebrow (Arabic)'),
                    TextInput::make('strip_tag_en')->label('Eyebrow (English)'),
                    TextInput::make('strip_title_ar')->label('Title (Arabic)'),
                    TextInput::make('strip_title_en')->label('Title (English)'),
                    TextInput::make('services_cta_ar')->label('CTA button (Arabic)'),
                    TextInput::make('services_cta_en')->label('CTA button (English)'),
                ]),
        ];
    }
}
