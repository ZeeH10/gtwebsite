<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerRequest extends Model
{
    protected $fillable = ['name', 'contact', 'request', 'pastors_only'];

    protected $casts = ['pastors_only' => 'boolean'];
}
