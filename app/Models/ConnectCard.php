<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConnectCard extends Model
{
    protected $guarded = [];

    protected $casts = ['interests' => 'array', 'visited_on' => 'date', 'consent_at' => 'datetime'];

    public const INTERESTS = [
        'home_group' => 'Joining a home group',
        'membership' => 'Becoming a member',
        'baptism' => 'Baptism',
        'serving' => 'Serving in a ministry',
        'prayer' => 'Prayer',
        'pastor' => 'Meeting a pastor',
    ];

    public const STATUSES = ['new' => 'New', 'contacted' => 'Contacted', 'added' => 'Added as member'];

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
