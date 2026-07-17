<?php

namespace App\Filament\Resources\EducationItems\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EducationItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('institution_ar')->label('Institution (Arabic)')->required(),
                        TextInput::make('institution_en')->label('Institution (English)')->required(),
                        Textarea::make('detail_ar')->label('Detail (Arabic)')->required()->rows(2),
                        Textarea::make('detail_en')->label('Detail (English)')->required()->rows(2),
                        TextInput::make('sort_order')->numeric()->default(0)->columnSpanFull(),
                    ]),
            ]);
    }
}
