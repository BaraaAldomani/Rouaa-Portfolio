<?php

namespace App\Filament\Pages;

use App\Support\SettingsDefaults;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class PagesSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel = 'Page headers';

    protected static ?string $title = 'Inner page headers';

    protected static ?int $navigationSort = 4;

    public static function group(): string
    {
        return 'pages';
    }

    public static function defaultValues(): array
    {
        return SettingsDefaults::pages();
    }

    protected function formSchema(): array
    {
        return [
            $this->pageSection('About', 'about'),
            $this->pageSection('Services', 'services'),
            $this->pageSection('Training', 'training'),
            $this->pageSection('Contact', 'contact'),
        ];
    }

    private function pageSection(string $label, string $key): Section
    {
        return Section::make($label)
            ->columns(2)
            ->schema([
                TextInput::make("{$key}_title_ar")->label('Title (Arabic)'),
                TextInput::make("{$key}_title_en")->label('Title (English)'),
                Textarea::make("{$key}_lead_ar")->label('Lead (Arabic)')->rows(2),
                Textarea::make("{$key}_lead_en")->label('Lead (English)')->rows(2),
            ]);
    }
}
