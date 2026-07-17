<?php

namespace App\Filament\Resources\Skills\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('label_ar')->label('Label (Arabic)')->required(),
                        TextInput::make('label_en')->label('Label (English)')->required(),
                        TextInput::make('sort_order')->numeric()->default(0)->columnSpanFull(),
                    ]),
            ]);
    }
}
