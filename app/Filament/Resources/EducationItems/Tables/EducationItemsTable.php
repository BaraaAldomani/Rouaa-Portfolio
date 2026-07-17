<?php

namespace App\Filament\Resources\EducationItems\Tables;

use App\Models\EducationItem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EducationItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('institution_en')
                    ->label('Institution')
                    ->description(fn (EducationItem $record): string => $record->institution_ar)
                    ->searchable(),
                TextColumn::make('detail_en')->label('Detail')->limit(60)->wrap()->toggleable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
