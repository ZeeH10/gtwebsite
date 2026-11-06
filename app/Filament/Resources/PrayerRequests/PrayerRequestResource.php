<?php

namespace App\Filament\Resources\PrayerRequests;

use App\Enums\Role;
use App\Filament\Concerns\RestrictedToRoles;
use App\Filament\Resources\PrayerRequests\Pages\ManagePrayerRequests;
use App\Models\PrayerRequest;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PrayerRequestResource extends Resource
{
    use RestrictedToRoles;

    protected static array $roles = [Role::Admin, Role::Pastor];

    protected static array $managerRoles = [Role::Pastor]; // requests only arrive from the website form

    protected static ?string $model = PrayerRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHandRaised;

    protected static string|\UnitEnum|null $navigationGroup = 'Inbox';

    protected static ?int $navigationSort = 1;

    /** "Pastors only" requests are visible to the Pastor role and no one else. */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        return auth()->user()?->role === Role::Pastor ? $query : $query->where('pastors_only', false);
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->where('status', 'new')->count() ?: null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('name')->default('Anonymous'),
            TextEntry::make('contact')->placeholder('Not given'),
            TextEntry::make('request')->columnSpanFull(),
            Select::make('status')->options(PrayerRequest::STATUSES)->required(),
            Textarea::make('notes')->label('Internal notes')->rows(3)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')->label('Received')->since()->sortable(),
                TextColumn::make('name')->placeholder('Anonymous'),
                TextColumn::make('request')->limit(80)->wrap(),
                IconColumn::make('pastors_only')->label('Pastors only')->boolean()->trueIcon(Heroicon::OutlinedLockClosed)->falseIcon(null),
                TextColumn::make('status')->badge()->formatStateUsing(fn ($state) => PrayerRequest::STATUSES[$state] ?? $state)
                    ->color(fn ($state) => $state === 'new' ? 'warning' : 'success'),
            ])
            ->filters([SelectFilter::make('status')->options(PrayerRequest::STATUSES)])
            ->recordActions([EditAction::make()->label('Open'), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ManagePrayerRequests::route('/')];
    }
}
