<?php

namespace App\Filament\Resources\Stats\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('context')
                            ->options(['hero' => 'Hero', 'banner' => 'Banner'])
                            ->required()
                            ->native(false)
                            ->default('hero'),
                        TextInput::make('sort_order')->numeric()->default(0),
                        TextInput::make('value_display')
                            ->label('Displayed value')
                            ->required()
                            ->helperText('Exactly as shown, e.g. +80, 17+, 1K+'),
                        TextInput::make('counter_target')
                            ->label('Counter target (number)')
                            ->numeric()
                            ->default(0)
                            ->helperText('Numeric target for the count-up animation.'),
                        TextInput::make('label_ar')->label('Label (Arabic)')->required(),
                        TextInput::make('label_en')->label('Label (English)')->required(),
                    ]),
            ]);
    }
}
