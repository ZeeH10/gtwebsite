<?php

namespace App\Filament\Resources\HomeGroups\Pages;

use App\Filament\Resources\HomeGroups\HomeGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageHomeGroups extends ManageRecords
{
    protected static string $resource = HomeGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
