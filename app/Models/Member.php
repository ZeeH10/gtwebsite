<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    protected $guarded = [];

    protected $casts = ['birthday' => 'date', 'joined_on' => 'date', 'consent_at' => 'datetime'];

    public const STATUSES = ['visitor' => 'Visitor', 'member' => 'Member', 'past_member' => 'Past member'];

    public function homeGroup(): BelongsTo
    {
        return $this->belongsTo(HomeGroup::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
