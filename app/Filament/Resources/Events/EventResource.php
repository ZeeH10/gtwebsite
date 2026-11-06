<?php

namespace App\Filament\Resources\Events;

use App\Enums\Role;
use App\Filament\Concerns\RestrictedToRoles;
use App\Filament\Resources\Events\Pages\ManageEvents;
use App\Models\Event;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventResource extends Resource
{
    use RestrictedToRoles;

    protected static array $roles = [Role::Admin, Role::Media];

    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->maxLength(150)->columnSpanFull(),
            DatePicker::make('starts_on')->label('Date')->required(),
            DatePicker::make('ends_on')->label('End date')->helperText('Only for events longer than one day.')->afterOrEqual('starts_on'),
            TextInput::make('time')->placeholder('09:00'),
            Toggle::make('is_published')->label('Show on website')->default(true),
            Textarea::make('summary')->rows(3)->columnSpanFull(),
            FileUpload::make('image')->image()->disk('public')->directory('events')->maxSize(4096)->columnSpanFull(),
            Toggle::make('image_is_poster')->label('Image is a poster')->helperText('Show the whole image (e.g. an event flyer) instead of cropping it.'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('starts_on', 'desc')
            ->columns([
                ImageColumn::make('image_url')->label('')->square(),
                TextColumn::make('title')->searchable()->wrap(),
                TextColumn::make('starts_on')->label('Date')->date('j M Y')->sortable(),
                TextColumn::make('time'),
                IconColumn::make('is_published')->label('On website')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageEvents::route('/')];
    }
}
