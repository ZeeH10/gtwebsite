<?php

namespace App\Filament\Resources\ServiceTimes\Pages;

use App\Filament\Resources\ServiceTimes\ServiceTimeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageServiceTimes extends ManageRecords
{
    protected static string $resource = ServiceTimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
