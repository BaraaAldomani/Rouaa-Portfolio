<?php

namespace App\Filament\Resources\TrainingSeries\Pages;

use App\Filament\Resources\TrainingSeries\TrainingSeriesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainingSeries extends EditRecord
{
    protected static string $resource = TrainingSeriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
