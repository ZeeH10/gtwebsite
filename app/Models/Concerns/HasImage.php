<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait HasImage
{
    /** Images (seeded and uploaded in /admin) live on the public disk; needs `php artisan storage:link`. */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}
