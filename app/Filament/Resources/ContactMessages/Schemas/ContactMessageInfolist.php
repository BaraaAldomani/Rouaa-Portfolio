<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Sender')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email')->copyable()->icon('heroicon-m-envelope'),
                        TextEntry::make('locale')->badge(),
                        TextEntry::make('created_at')->label('Received')->dateTime(),
                        TextEntry::make('ip')->label('IP address')->badge()->color('gray'),
                    ]),
                Section::make('Message')
                    ->schema([
                        TextEntry::make('message')->hiddenLabel()->prose(),
                    ]),
            ]);
    }
}
