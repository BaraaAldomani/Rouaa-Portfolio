<?php

namespace App\Filament\Pages;

use App\Support\SettingsDefaults;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class TrainingSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $navigationLabel = 'Training';

    protected static ?string $title = 'Training page';

    protected static ?int $navigationSort = 6;

    public static function group(): string
    {
        return 'training';
    }

    public static function defaultValues(): array
    {
        return SettingsDefaults::training();
    }

    protected function formSchema(): array
    {
        return [
            Section::make('Intro')
                ->columns(2)
                ->schema([
                    TextInput::make('intro_heading_ar')->label('Heading (Arabic)'),
                    TextInput::make('intro_heading_en')->label('Heading (English)'),
                    Textarea::make('intro_ar')->label('Intro (Arabic)')->rows(5)
                        ->helperText('Separate paragraphs with a blank line.'),
                    Textarea::make('intro_en')->label('Intro (English)')->rows(5)
                        ->helperText('Separate paragraphs with a blank line.'),
                ]),
            Section::make('Partner box')
                ->columns(2)
                ->schema([
                    TextInput::make('partner_heading_ar')->label('Heading (Arabic)'),
                    TextInput::make('partner_heading_en')->label('Heading (English)'),
                    TextInput::make('partner_cert')->label('Certification badge')->columnSpanFull(),
                    TextInput::make('partner_collab_pre_ar')->label('Collaboration line — before (Arabic)'),
                    TextInput::make('partner_collab_pre_en')->label('Collaboration line — before (English)'),
                    TextInput::make('partner_name')->label('Partner name')->columnSpanFull(),
                    TextInput::make('partner_collab_post_ar')->label('Collaboration line — after (Arabic)'),
                    TextInput::make('partner_collab_post_en')->label('Collaboration line — after (English)'),
                ]),
            Section::make('Call-to-action')
                ->columns(2)
                ->schema([
                    TextInput::make('cta_heading_ar')->label('Heading (Arabic)'),
                    TextInput::make('cta_heading_en')->label('Heading (English)'),
                    Textarea::make('cta_text_ar')->label('Text (Arabic)')->rows(2),
                    Textarea::make('cta_text_en')->label('Text (English)')->rows(2),
                    TextInput::make('cta_button_ar')->label('Button (Arabic)'),
                    TextInput::make('cta_button_en')->label('Button (English)'),
                ]),
        ];
    }
}
