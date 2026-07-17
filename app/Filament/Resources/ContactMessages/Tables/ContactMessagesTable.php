<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')->searchable()->weight('bold'),
                TextColumn::make('email')->searchable()->copyable()->icon('heroicon-m-envelope'),
                TextColumn::make('message')->limit(60)->wrap()->toggleable(),
                TextColumn::make('locale')->badge()->toggleable(),
                TextColumn::make('created_at')->label('Received')->dateTime()->since()->sortable(),
            ])
            ->filters([
                SelectFilter::make('locale')->options(['ar' => 'Arabic', 'en' => 'English']),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
