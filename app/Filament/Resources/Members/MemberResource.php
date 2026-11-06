<?php

namespace App\Filament\Resources\Members;

use App\Enums\Role;
use App\Filament\Concerns\RestrictedToRoles;
use App\Filament\Resources\Members\Pages\ManageMembers;
use App\Filament\Resources\HomeGroups\HomeGroupResource;
use App\Models\Member;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class MemberResource extends Resource
{
    use RestrictedToRoles;

    protected static array $roles = [Role::Admin, Role::Pastor, Role::GroupLeader];

    protected static ?string $model = Member::class;

    protected static ?string $modelLabel = 'person';

    protected static ?string $pluralModelLabel = 'people';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|\UnitEnum|null $navigationGroup = 'People';

    protected static ?int $navigationSort = 1;

    /** Home group leaders only see people in the groups they lead. */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        return $user?->role === Role::GroupLeader
            ? $query->whereHas('homeGroup', fn ($q) => $q->where('leader_user_id', $user->id))
            : $query;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('first_name')->required(),
            TextInput::make('last_name'),
            TextInput::make('phone')->tel(),
            TextInput::make('email')->email(),
            DatePicker::make('birthday'),
            TextInput::make('area')->placeholder('e.g. North End'),
            Select::make('status')->options(Member::STATUSES)->default('member')->required(),
            DatePicker::make('joined_on'),
            Select::make('home_group_id')->label('Home group')
                ->relationship('homeGroup', 'name', fn (Builder $q) => HomeGroupResource::scopeForUser($q))
                ->required(fn () => auth()->user()?->role === Role::GroupLeader)
                // Server-side guard: a leader can only file people under a group they lead.
                ->rule(fn () => auth()->user()?->role === Role::GroupLeader
                    ? Rule::exists('home_groups', 'id')->where('leader_user_id', auth()->id())
                    : 'nullable'),
            DateTimePicker::make('consent_at')->label('POPIA consent given')->helperText('When this person agreed to the church keeping their details.'),
            Textarea::make('notes')->rows(3)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('first_name')
            ->columns([
                TextColumn::make('first_name')->label('Name')->formatStateUsing(fn (Member $record) => $record->full_name)->searchable(['first_name', 'last_name']),
                TextColumn::make('phone')->searchable(),
                TextColumn::make('homeGroup.name')->label('Home group')->placeholder('None'),
                TextColumn::make('birthday')->date('j M')->sortable(),
                TextColumn::make('status')->badge()->formatStateUsing(fn ($state) => Member::STATUSES[$state] ?? $state)
                    ->color(fn ($state) => match ($state) { 'member' => 'success', 'visitor' => 'info', default => 'gray' }),
            ])
            ->filters([
                SelectFilter::make('status')->options(Member::STATUSES),
                SelectFilter::make('home_group_id')->label('Home group')->relationship('homeGroup', 'name'),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageMembers::route('/')];
    }
}
