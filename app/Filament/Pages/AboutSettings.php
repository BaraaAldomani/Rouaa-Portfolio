<?php

namespace App\Filament\Pages;

use App\Support\SettingsDefaults;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class AboutSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static ?string $navigationLabel = 'About';

    protected static ?string $title = 'About page';

    protected static ?int $navigationSort = 5;

    public static function group(): string
    {
        return 'about';
    }

    public static function defaultValues(): array
    {
        return SettingsDefaults::about();
    }

    protected function formSchema(): array
    {
        return [
            Section::make('Story')
                ->columns(2)
                ->schema([
                    TextInput::make('story_heading_ar')->label('Heading (Arabic)'),
                    TextInput::make('story_heading_en')->label('Heading (English)'),
                    Textarea::make('story_ar')->label('Story (Arabic)')->rows(6)
                        ->helperText('Separate paragraphs with a blank line.'),
                    Textarea::make('story_en')->label('Story (English)')->rows(6)
                        ->helperText('Separate paragraphs with a blank line.'),
                ]),
            Section::make('Rakeez badge')
                ->columns(2)
                ->schema([
                    TextInput::make('rakeez_title_ar')->label('Title (Arabic)'),
                    TextInput::make('rakeez_title_en')->label('Title (English)'),
                    TextInput::make('rakeez_text_ar')->label('Text (Arabic)'),
                    TextInput::make('rakeez_text_en')->label('Text (English)'),
                ]),
            Section::make('Section headings')
                ->columns(2)
                ->schema([
                    TextInput::make('career_heading_ar')->label('Career heading (Arabic)'),
                    TextInput::make('career_heading_en')->label('Career heading (English)'),
                    TextInput::make('education_eyebrow_ar')->label('Education eyebrow (Arabic)'),
                    TextInput::make('education_eyebrow_en')->label('Education eyebrow (English)'),
                    TextInput::make('education_title_ar')->label('Education title (Arabic)'),
                    TextInput::make('education_title_en')->label('Education title (English)'),
                ]),
        ];
    }
}
