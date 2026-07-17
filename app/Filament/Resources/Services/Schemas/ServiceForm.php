<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Setup')
                    ->columns(3)
                    ->schema([
                        TextInput::make('key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Stable identifier, e.g. bookkeeping.'),
                        TextInput::make('icon')
                            ->label('Icon (emoji)')
                            ->maxLength(8),
                        TextInput::make('sort_order')->numeric()->default(0),
                    ]),
                Section::make('Content')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title_ar')->label('Title (Arabic)')->required(),
                        TextInput::make('title_en')->label('Title (English)')->required(),
                        Textarea::make('summary_ar')->label('Strip summary (Arabic)')->required()->rows(2),
                        Textarea::make('summary_en')->label('Strip summary (English)')->required()->rows(2),
                        Textarea::make('description_ar')->label('Detail (Arabic)')->required()->rows(4),
                        Textarea::make('description_en')->label('Detail (English)')->required()->rows(4),
                        TagsInput::make('features_ar')->label('Features (Arabic)')->placeholder('Add feature'),
                        TagsInput::make('features_en')->label('Features (English)')->placeholder('Add feature'),
                        Textarea::make('legal_note_ar')->label('Legal note (Arabic)')->rows(2)
                            ->helperText('Optional regulatory note shown under the service.'),
                        Textarea::make('legal_note_en')->label('Legal note (English)')->rows(2),
                    ]),
            ]);
    }
}
