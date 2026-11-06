<?php

namespace App\Models;

use App\Models\Concerns\HasImage;
use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    use HasImage;

    protected $guarded = [];

    protected $casts = ['is_published' => 'boolean'];
}
