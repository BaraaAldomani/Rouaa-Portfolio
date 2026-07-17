<?php

namespace App\Filament\Resources\TrainingSeries\Pages;

use App\Filament\Resources\TrainingSeries\TrainingSeriesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingSeries extends ListRecords
{
    protected static string $resource = TrainingSeriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
