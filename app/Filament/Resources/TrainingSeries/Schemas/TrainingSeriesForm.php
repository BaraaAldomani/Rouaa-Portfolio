<?php

namespace App\Filament\Resources\TrainingSeries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingSeriesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title_ar')->label('Title (Arabic)')->required(),
                        TextInput::make('title_en')->label('Title (English)')->required(),
                        TextInput::make('tag_ar')->label('Tag (Arabic)'),
                        TextInput::make('tag_en')->label('Tag (English)'),
                        TextInput::make('sort_order')->numeric()->default(0)->columnSpanFull(),
                    ]),
            ]);
    }
}
