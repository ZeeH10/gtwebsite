<?php

namespace App\Filament\Resources\Ministries;

use App\Enums\Role;
use App\Filament\Concerns\RestrictedToRoles;
use App\Filament\Resources\Ministries\Pages\ManageMinistries;
use App\Models\Ministry;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
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

class MinistryResource extends Resource
{
    use RestrictedToRoles;

    protected static array $roles = [Role::Admin, Role::Media];

    protected static ?string $model = Ministry::class;

    protected static ?string $pluralModelLabel = 'ministries';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static string|\UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(100),
            Toggle::make('is_published')->label('Show on website')->default(true)->inline(false),
            Textarea::make('summary')->required()->rows(3)->columnSpanFull(),
            FileUpload::make('image')->image()->disk('public')->directory('ministries')->maxSize(4096)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                ImageColumn::make('image_url')->label('')->square(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('summary')->limit(70),
                IconColumn::make('is_published')->label('On website')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageMinistries::route('/')];
    }
}
