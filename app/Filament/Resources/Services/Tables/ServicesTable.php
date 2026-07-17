<?php

namespace App\Filament\Resources\Services\Tables;

use App\Models\Service;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('icon')->label('')->size('lg'),
                TextColumn::make('title_en')
                    ->label('Title')
                    ->description(fn (Service $record): string => $record->title_ar)
                    ->searchable(),
                TextColumn::make('key')->badge()->color('gray')->toggleable(),
                TextColumn::make('legal_note_en')
                    ->label('Legal note')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => $state ? 'yes' : '—')
                    ->color(fn (?string $state): string => $state ? 'warning' : 'gray')
                    ->toggleable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
