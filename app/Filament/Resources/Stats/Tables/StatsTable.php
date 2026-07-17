<?php

namespace App\Filament\Resources\Stats\Tables;

use App\Models\Stat;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultGroup('context')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('value_display')->label('Value')->weight('bold'),
                TextColumn::make('label_en')
                    ->label('Label')
                    ->description(fn (Stat $record): string => $record->label_ar)
                    ->searchable(),
                TextColumn::make('context')->badge(),
                TextColumn::make('counter_target')->label('Target')->toggleable(),
            ])
            ->filters([
                SelectFilter::make('context')->options(['hero' => 'Hero', 'banner' => 'Banner']),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
