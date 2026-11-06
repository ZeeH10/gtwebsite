<?php

namespace App\Filament\Resources\HomeGroups;

use App\Enums\Role;
use App\Filament\Concerns\RestrictedToRoles;
use App\Filament\Resources\HomeGroups\Pages\ManageHomeGroups;
use App\Models\HomeGroup;
use App\Models\User;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HomeGroupResource extends Resource
{
    use RestrictedToRoles;

    protected static array $roles = [Role::Admin, Role::Pastor, Role::GroupLeader];

    protected static array $managerRoles = [Role::Admin, Role::Pastor];

    protected static ?string $model = HomeGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static string|\UnitEnum|null $navigationGroup = 'People';

    protected static ?int $navigationSort = 2;

    public static function scopeForUser(Builder $query): Builder
    {
        $user = auth()->user();

        return $user?->role === Role::GroupLeader ? $query->where('leader_user_id', $user->id) : $query;
    }

    public static function getEloquentQuery(): Builder
    {
        return static::scopeForUser(parent::getEloquentQuery());
    }

    public static function form(Schema $schema): Schema
    {
        $leaderOnly = fn () => auth()->user()?->role === Role::GroupLeader;

        return $schema->components([
            TextInput::make('name')->required()->placeholder('North End group'),
            TextInput::make('area')->required()->helperText('Shown on the website. Never put a home address here.'),
            Select::make('meeting_day')->options(array_combine($d = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], $d))->default('Tuesday'),
            TextInput::make('meeting_time')->default('18:00'),
            Select::make('leader_user_id')->label('Leader (login)')->disabled($leaderOnly)
                ->options(fn () => User::where('role', Role::GroupLeader)->pluck('name', 'id'))
                ->helperText('Leaders need a login with the "Home group leader" role.'),
            Toggle::make('is_active')->label('Active (shown on website)')->default(true)->inline(false),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('area'),
                TextColumn::make('meeting_day')->label('Meets')->formatStateUsing(fn (HomeGroup $r) => "{$r->meeting_day} {$r->meeting_time}"),
                TextColumn::make('leader.name')->label('Leader')->placeholder('None'),
                TextColumn::make('members_count')->counts('members')->label('People'),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageHomeGroups::route('/')];
    }
}
