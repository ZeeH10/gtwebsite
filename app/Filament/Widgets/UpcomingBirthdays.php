<?php

namespace App\Filament\Widgets;

use App\Enums\Role;
use App\Filament\Resources\Members\MemberResource;
use App\Models\Member;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\DB;

class UpcomingBirthdays extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Birthdays in the next 7 days';

    public static function canView(): bool
    {
        return auth()->user()?->hasRole(Role::Admin, Role::Pastor, Role::GroupLeader) ?? false;
    }

    public function table(Table $table): Table
    {
        $days = collect(range(0, 6))->map(fn ($i) => today()->addDays($i)->format('m-d'))->all();
        $monthDay = DB::getDriverName() === 'sqlite' ? "strftime('%m-%d', birthday)" : "DATE_FORMAT(birthday, '%m-%d')";

        return $table
            // Reuses the People scoping, so home group leaders only see their own group.
            ->query(MemberResource::getEloquentQuery()->whereNotNull('birthday')->whereIn(DB::raw($monthDay), $days))
            ->defaultSort(DB::raw($monthDay))
            ->paginated(false)
            ->emptyStateHeading('No birthdays this week')
            ->columns([
                TextColumn::make('first_name')->label('Name')->formatStateUsing(fn (Member $record) => $record->full_name),
                TextColumn::make('birthday')->date('l j F'),
                TextColumn::make('phone'),
                TextColumn::make('homeGroup.name')->label('Home group')->placeholder('None'),
            ]);
    }
}
