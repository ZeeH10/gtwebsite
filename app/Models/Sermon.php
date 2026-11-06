<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sermon extends Model
{
    protected $guarded = [];

    protected $casts = ['preached_on' => 'date', 'is_published' => 'boolean'];

    /** Privacy-friendly player URL for a YouTube or Facebook video link. */
    public function getEmbedUrlAttribute(): string
    {
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|live/|embed/|shorts/))([\w-]{11})~', $this->video_url, $m)) {
            return 'https://www.youtube-nocookie.com/embed/'.$m[1];
        }

        return 'https://www.facebook.com/plugins/video.php?show_text=false&href='.urlencode($this->video_url);
    }
}
