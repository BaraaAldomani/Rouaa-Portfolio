<?php

namespace App\Filament\Resources\Experiences\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('period_ar')->label('Period (Arabic)')->required(),
                        TextInput::make('period_en')->label('Period (English)')->required(),
                        TextInput::make('role_ar')->label('Role (Arabic)')->required(),
                        TextInput::make('role_en')->label('Role (English)')->required(),
                        TextInput::make('org_ar')->label('Organization (Arabic)')->required(),
                        TextInput::make('org_en')->label('Organization (English)')->required(),
                        Textarea::make('description_ar')->label('Description (Arabic)')->required()->rows(3),
                        Textarea::make('description_en')->label('Description (English)')->required()->rows(3),
                        TextInput::make('sort_order')->numeric()->default(0)->columnSpanFull(),
                    ]),
            ]);
    }
}
