<?php

namespace App\Filament\Imports;

use App\Models\Member;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

/**
 * Import people from a CSV (save the Excel sheet as CSV). Columns are mapped on upload,
 * so the spreadsheet headings don't need to match exactly.
 */
class MemberImporter extends Importer
{
    protected static ?string $model = Member::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('first_name')->requiredMapping()->rules(['required', 'max:100'])->guess(['first name', 'name', 'firstname']),
            ImportColumn::make('last_name')->guess(['surname', 'last name', 'lastname']),
            ImportColumn::make('phone')->guess(['cell', 'mobile', 'phone number', 'contact']),
            ImportColumn::make('email')->rules(['nullable', 'email']),
            ImportColumn::make('birthday')->rules(['nullable', 'date'])->guess(['date of birth', 'dob', 'birth date']),
            ImportColumn::make('area')->guess(['suburb', 'location', 'address']),
            ImportColumn::make('status')
                ->helperText('member, visitor or past member (empty = member)')
                ->castStateUsing(fn (?string $state) => match (strtolower(trim((string) $state))) {
                    'visitor', 'guest' => 'visitor',
                    'past', 'past member', 'former', 'inactive' => 'past_member',
                    default => 'member',
                }),
            ImportColumn::make('joined_on')->rules(['nullable', 'date']),
            ImportColumn::make('homeGroup')->label('Home group')->relationship(resolveUsing: 'name'),
            ImportColumn::make('notes'),
        ];
    }

    /** Update an existing person with the same email or phone instead of creating a duplicate. */
    public function resolveRecord(): Member
    {
        $email = $this->data['email'] ?? null;
        $phone = $this->data['phone'] ?? null;

        return Member::query()
            ->when($email || $phone, fn ($q) => $q->where(fn ($q) => $q
                ->when($email, fn ($q) => $q->orWhere('email', $email))
                ->when($phone, fn ($q) => $q->orWhere('phone', $phone))))
            ->when(! $email && ! $phone, fn ($q) => $q->whereRaw('1 = 0'))
            ->first() ?? new Member;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'People import finished: '.Number::format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failed = $import->getFailedRowsCount()) {
            $body .= ' '.Number::format($failed).' '.str('row')->plural($failed).' failed. Download them to see why.';
        }

        return $body;
    }
}
