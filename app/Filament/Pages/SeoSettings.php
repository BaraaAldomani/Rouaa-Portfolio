<?php

namespace App\Filament\Pages;

use App\Support\SettingsDefaults;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class SeoSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMagnifyingGlass;

    protected static ?string $navigationLabel = 'SEO';

    protected static ?string $title = 'SEO';

    protected static ?int $navigationSort = 8;

    public static function group(): string
    {
        return 'seo';
    }

    public static function defaultValues(): array
    {
        return SettingsDefaults::seo();
    }

    protected function formSchema(): array
    {
        return [
            $this->seoSection('Home', 'home'),
            $this->seoSection('About', 'about'),
            $this->seoSection('Services', 'services'),
            $this->seoSection('Training', 'training'),
            $this->seoSection('Contact', 'contact'),
        ];
    }

    private function seoSection(string $label, string $key): Section
    {
        return Section::make($label)
            ->columns(2)
            ->collapsible()
            ->schema([
                TextInput::make("{$key}_title_ar")->label('Title (Arabic)'),
                TextInput::make("{$key}_title_en")->label('Title (English)'),
                Textarea::make("{$key}_description_ar")->label('Description (Arabic)')->rows(2),
                Textarea::make("{$key}_description_en")->label('Description (English)')->rows(2),
            ]);
    }
}
