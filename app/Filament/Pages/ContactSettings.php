<?php

namespace App\Filament\Pages;

use App\Support\SettingsDefaults;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ContactSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $navigationLabel = 'Contact';

    protected static ?string $title = 'Contact & links';

    protected static ?int $navigationSort = 7;

    public static function group(): string
    {
        return 'contact';
    }

    public static function defaultValues(): array
    {
        return SettingsDefaults::contact();
    }

    protected function formSchema(): array
    {
        return [
            Section::make('Contact details')
                ->columns(2)
                ->schema([
                    TextInput::make('email')->label('Email')->email(),
                    TextInput::make('phone_display')->label('Phone (display)'),
                    TextInput::make('whatsapp')->label('WhatsApp (digits only)')->helperText('International format, digits only, e.g. 966533632669.'),
                    TextInput::make('location_ar')->label('Location (Arabic)'),
                    TextInput::make('location_en')->label('Location (English)'),
                ]),
            Section::make('Social links')
                ->columns(2)
                ->schema([
                    TextInput::make('linkedin')->label('LinkedIn URL')->url(),
                    TextInput::make('youtube_url')->label('YouTube URL')->url(),
                    TextInput::make('youtube_label_ar')->label('YouTube label (Arabic)'),
                    TextInput::make('youtube_label_en')->label('YouTube label (English)'),
                    TextInput::make('social_heading_ar')->label('Social heading (Arabic)'),
                    TextInput::make('social_heading_en')->label('Social heading (English)'),
                ]),
            Section::make('Global "have a question" CTA')
                ->description('Shown at the foot of the Services page.')
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
