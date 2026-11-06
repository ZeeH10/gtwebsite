<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Role: string implements HasLabel
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';               // communications & admin: everything except pastors-only prayers
    case Pastor = 'pastor';             // the only role that sees pastors-only prayer requests
    case Media = 'media';               // website content: events, ministries, sermons, service times
    case GroupLeader = 'group_leader';  // own home group's members only

    public function getLabel(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super admin',
            self::Admin => 'Admin / communications',
            self::Pastor => 'Pastor',
            self::Media => 'Media team',
            self::GroupLeader => 'Home group leader',
        };
    }
}
