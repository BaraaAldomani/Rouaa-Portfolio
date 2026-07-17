<?php

namespace App\Filament\Resources\TrainingSeries;

use App\Filament\Resources\TrainingSeries\Pages\CreateTrainingSeries;
use App\Filament\Resources\TrainingSeries\Pages\EditTrainingSeries;
use App\Filament\Resources\TrainingSeries\Pages\ListTrainingSeries;
use App\Filament\Resources\TrainingSeries\RelationManagers\CoursesRelationManager;
use App\Filament\Resources\TrainingSeries\Schemas\TrainingSeriesForm;
use App\Filament\Resources\TrainingSeries\Tables\TrainingSeriesTable;
use App\Models\TrainingSeries;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrainingSeriesResource extends Resource
{
    protected static ?string $model = TrainingSeries::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Training Series';

    protected static ?string $recordTitleAttribute = 'title_en';

    public static function form(Schema $schema): Schema
    {
        return TrainingSeriesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingSeriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CoursesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrainingSeries::route('/'),
            'create' => CreateTrainingSeries::route('/create'),
            'edit' => EditTrainingSeries::route('/{record}/edit'),
        ];
    }
}
