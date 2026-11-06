<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerRequest extends Model
{
    protected $fillable = ['name', 'contact', 'request', 'pastors_only', 'consent_at', 'status', 'notes'];

    protected $casts = ['pastors_only' => 'boolean', 'consent_at' => 'datetime'];

    public const STATUSES = ['new' => 'New', 'prayed' => 'Prayed for', 'followed_up' => 'Followed up'];
}
