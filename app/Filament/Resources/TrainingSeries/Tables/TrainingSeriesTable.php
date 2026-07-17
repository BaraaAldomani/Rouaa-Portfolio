<?php

namespace App\Filament\Resources\TrainingSeries\Tables;

use App\Models\TrainingSeries;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingSeriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('title_en')
                    ->label('Series')
                    ->description(fn (TrainingSeries $record): string => $record->title_ar)
                    ->searchable(),
                TextColumn::make('tag_en')->label('Tag')->badge()->color('gray')->toggleable(),
                TextColumn::make('courses_count')->counts('courses')->label('Courses')->badge(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
