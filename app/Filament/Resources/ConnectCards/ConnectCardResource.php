<?php

namespace App\Filament\Resources\ConnectCards;

use App\Enums\Role;
use App\Filament\Concerns\RestrictedToRoles;
use App\Filament\Resources\ConnectCards\Pages\ManageConnectCards;
use App\Models\ConnectCard;
use App\Models\Member;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ConnectCardResource extends Resource
{
    use RestrictedToRoles;

    protected static array $roles = [Role::Admin, Role::Pastor];

    protected static ?string $model = ConnectCard::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static string|\UnitEnum|null $navigationGroup = 'Inbox';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return (string) ConnectCard::where('status', 'new')->count() ?: null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('name'),
            TextEntry::make('phone')->placeholder('Not given'),
            TextEntry::make('email')->placeholder('Not given'),
            TextEntry::make('area')->placeholder('Not given'),
            TextEntry::make('visited_on')->label('First visit')->date('j M Y')->placeholder('Not given'),
            TextEntry::make('how_heard')->label('Heard about us')->placeholder('Not given'),
            TextEntry::make('interests')->label('Interested in')->badge()
                ->formatStateUsing(fn ($state) => ConnectCard::INTERESTS[$state] ?? $state)->columnSpanFull(),
            TextEntry::make('message')->placeholder('No message')->columnSpanFull(),
            Select::make('status')->options(ConnectCard::STATUSES)->required(),
            Select::make('assigned_user_id')->label('Follow-up by')->options(fn () => User::whereNotNull('role')->pluck('name', 'id')),
            Textarea::make('notes')->label('Follow-up notes')->rows(3)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')->label('Received')->since()->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('area'),
                TextColumn::make('assignee.name')->label('Follow-up by')->placeholder('Unassigned'),
                TextColumn::make('status')->badge()->formatStateUsing(fn ($state) => ConnectCard::STATUSES[$state] ?? $state)
                    ->color(fn ($state) => match ($state) { 'new' => 'warning', 'contacted' => 'info', default => 'success' }),
            ])
            ->filters([SelectFilter::make('status')->options(ConnectCard::STATUSES)])
            ->recordActions([
                EditAction::make()->label('Open'),
                Action::make('addAsMember')
                    ->label('Add as member')
                    ->icon(Heroicon::OutlinedUserPlus)
                    ->visible(fn (ConnectCard $record) => ! $record->member_id)
                    ->requiresConfirmation()
                    ->modalDescription('Creates a person record (status: Visitor) from this card so they can be followed up and added to a home group.')
                    ->action(function (ConnectCard $record) {
                        [$first, $last] = array_pad(explode(' ', $record->name, 2), 2, null);
                        $member = Member::create([
                            'first_name' => $first, 'last_name' => $last, 'phone' => $record->phone, 'email' => $record->email,
                            'area' => $record->area, 'status' => 'visitor', 'consent_at' => $record->consent_at,
                            'notes' => 'From connect card '.$record->created_at->format('j M Y'),
                        ]);
                        $record->update(['member_id' => $member->id, 'status' => 'added']);
                        Notification::make()->title('Added to People')->success()->send();
                    }),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageConnectCards::route('/')];
    }
}
