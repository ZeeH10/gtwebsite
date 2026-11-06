<?php

namespace App\Filament\Resources\Sermons;

use App\Enums\Role;
use App\Filament\Concerns\RestrictedToRoles;
use App\Filament\Resources\Sermons\Pages\ManageSermons;
use App\Models\Sermon;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SermonResource extends Resource
{
    use RestrictedToRoles;

    protected static array $roles = [Role::Admin, Role::Media];

    protected static ?string $model = Sermon::class;

    protected static ?string $modelLabel = 'sermon or video';

    protected static ?string $pluralModelLabel = 'sermons & videos';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->columnSpanFull(),
            TextInput::make('preacher')->placeholder('Pastor Gratitude Kudyachete'),
            DatePicker::make('preached_on')->label('Date')->required()->default(today()),
            TextInput::make('video_url')->label('Facebook or YouTube link')->url()->required()->columnSpanFull(),
            Toggle::make('is_published')->label('Show on website')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('preached_on', 'desc')
            ->columns([
                TextColumn::make('title')->searchable()->wrap(),
                TextColumn::make('preacher'),
                TextColumn::make('preached_on')->label('Date')->date('j M Y')->sortable(),
                IconColumn::make('is_published')->label('On website')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageSermons::route('/')];
    }
}
