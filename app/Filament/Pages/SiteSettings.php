<?php

namespace App\Filament\Pages;

use App\Enums\Role;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class SiteSettings extends Page
{
    protected string $view = 'filament.pages.site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 5;

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole(Role::Admin) ?? false;
    }

    public function mount(): void
    {
        $this->form->fill(collect(Setting::defaults())->map(fn ($v, $key) => Setting::get($key))->all());
    }

    public function form(Schema $schema): Schema
    {
        return $schema->statePath('data')->components([
            Section::make('Pastor')->columns(2)->schema([
                TextInput::make('pastor_name')->required(),
                TextInput::make('pastor_title')->required(),
                Textarea::make('pastor_bio')->label('Bio')->rows(6)->helperText('Leave a blank line between paragraphs.')->columnSpanFull(),
            ]),
            Section::make('About page')->schema([
                Textarea::make('story')->label('Our story')->rows(6)->helperText('Leave a blank line between paragraphs.'),
            ]),
            Section::make('Giving: banking details')->columns(2)->schema([
                TextInput::make('bank')->required(),
                TextInput::make('account_name')->required(),
                TextInput::make('account_number')->required(),
                TextInput::make('branch_code')->required(),
            ]),
            Section::make('Online')->schema([
                TextInput::make('youtube')->label('YouTube channel link')->url(),
            ]),
            Section::make('Privacy (POPIA)')->columns(2)->description('Shown on the privacy page as the person to contact about personal information.')->schema([
                TextInput::make('information_officer')->label('Information Officer name'),
                TextInput::make('information_officer_contact')->label('Information Officer email or phone'),
            ]),
        ]);
    }

    public function save(): void
    {
        Setting::put($this->form->getState());
        Notification::make()->title('Settings saved')->success()->send();
    }
}
