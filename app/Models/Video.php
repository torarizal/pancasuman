<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'video_url',
        'embed_url',
        'platform',
        'thumbnail',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Parse video URL to detect platform, embed URL, and default thumbnail.
     */
    public static function extractMeta(string $url): array
    {
        $platform = 'other';
        $embedUrl = null;
        $thumbnail = null;

        // YouTube patterns (standard, short, embed)
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            $platform = 'youtube';
            $videoId = $matches[1];
            $embedUrl = "https://www.youtube-nocookie.com/embed/{$videoId}?autoplay=1";
            $thumbnail = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
        }
        // Instagram
        elseif (preg_match('/instagram\.com\/(?:p|reel|tv)\/([a-zA-Z0-9_-]+)/i', $url, $matches)) {
            $platform = 'instagram';
            $embedUrl = "https://www.instagram.com/p/{$matches[1]}/embed";
        }
        // TikTok
        elseif (preg_match('/tiktok\.com\/.*\/video\/(\d+)/i', $url, $matches)) {
            $platform = 'tiktok';
            $embedUrl = "https://www.tiktok.com/embed/v2/{$matches[1]}";
        }
        // Facebook
        elseif (preg_match('/facebook\.com/i', $url)) {
            $platform = 'facebook';
            $embedUrl = 'https://www.facebook.com/plugins/video.php?href='.urlencode($url).'&show_text=0';
        }

        return [
            'platform' => $platform,
            'embed_url' => $embedUrl ?: $url,
            'thumbnail' => $thumbnail,
        ];
    }
}
