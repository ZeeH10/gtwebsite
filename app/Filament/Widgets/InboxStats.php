<?php

namespace App\Filament\Widgets;

use App\Enums\Role;
use App\Filament\Resources\ConnectCards\ConnectCardResource;
use App\Filament\Resources\PrayerRequests\PrayerRequestResource;
use App\Models\ConnectCard;
use App\Models\Member;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InboxStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->user()?->hasRole(Role::Admin, Role::Pastor) ?? false;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('New prayer requests', PrayerRequestResource::getEloquentQuery()->where('status', 'new')->count())
                ->url(PrayerRequestResource::getUrl()),
            Stat::make('New connect cards', ConnectCard::where('status', 'new')->count())
                ->url(ConnectCardResource::getUrl()),
            Stat::make('Members', Member::where('status', 'member')->count()),
        ];
    }
}
