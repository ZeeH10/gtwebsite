<?php

namespace App\Filament\Resources\Members\Pages;

use App\Enums\Role;
use App\Filament\Imports\MemberImporter;
use App\Filament\Resources\Members\MemberResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMembers extends ManageRecords
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->label('Import from spreadsheet (CSV)')
                ->importer(MemberImporter::class)
                ->visible(fn () => auth()->user()?->hasRole(Role::Admin)),
            CreateAction::make(),
        ];
    }
}
