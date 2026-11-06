<?php

namespace App\Filament\Resources\ConnectCards\Pages;

use App\Filament\Resources\ConnectCards\ConnectCardResource;
use Filament\Resources\Pages\ManageRecords;

class ManageConnectCards extends ManageRecords
{
    protected static string $resource = ConnectCardResource::class;

    protected function getHeaderActions(): array
    {
        return []; // entries arrive from the website form
    }
}
