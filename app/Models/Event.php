<?php

namespace App\Models;

use App\Models\Concerns\HasImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasImage;

    protected $guarded = [];

    protected $casts = ['starts_on' => 'date', 'ends_on' => 'date', 'is_published' => 'boolean', 'image_is_poster' => 'boolean'];

    public function scopeUpcoming(Builder $q): Builder
    {
        return $q->where('is_published', true)
            ->whereRaw('COALESCE(ends_on, starts_on) >= ?', [today()->toDateString()])
            ->orderBy('starts_on');
    }

    public function scopePast(Builder $q): Builder
    {
        return $q->where('is_published', true)
            ->whereRaw('COALESCE(ends_on, starts_on) < ?', [today()->toDateString()])
            ->orderByDesc('starts_on');
    }
}
