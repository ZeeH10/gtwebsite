<?php

namespace App\Filament\Resources\ServiceTimes;

use App\Enums\Role;
use App\Filament\Concerns\RestrictedToRoles;
use App\Filament\Resources\ServiceTimes\Pages\ManageServiceTimes;
use App\Models\ServiceTime;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServiceTimeResource extends Resource
{
    use RestrictedToRoles;

    protected static array $roles = [Role::Admin, Role::Media];

    protected static ?string $model = ServiceTime::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static string|\UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->placeholder('Morning service'),
            Select::make('day')->required()->options(array_combine($d = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], $d)),
            TextInput::make('time')->required()->placeholder('09:00 – 12:00'),
            Select::make('icon')->options(['sun' => 'Sun', 'home' => 'House', 'flame' => 'Flame', 'users' => 'People', 'book' => 'Bible', 'heart' => 'Heart'])->default('sun'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('day'),
                TextColumn::make('time'),
                TextColumn::make('name'),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageServiceTimes::route('/')];
    }
}
