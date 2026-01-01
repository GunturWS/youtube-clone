<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Like video
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Subscription (user subscribe channel)
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'subscriber_id');
    }

    // Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentLikes()
    {
        return $this->hasMany(CommentLike::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SUBSCRIPTION LOGIC (SESUAI CONTROLLER)
    |--------------------------------------------------------------------------
    */

    // ✅ Subscribe ke channel
    public function subscribeToChannel($channelId, $channelName, $channelThumbnail = null)
    {
        return $this->subscriptions()->create([
            'channel_id' => $channelId,
            'channel_name' => $channelName,
            'channel_thumbnail' => $channelThumbnail,
        ]);
    }

    // ✅ Check apakah user sudah subscribe channel tertentu
    public function isSubscribedTo($channelId)
    {
        return $this->subscriptions()
            ->where('channel_id', $channelId)
            ->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | LIKE LOGIC
    |--------------------------------------------------------------------------
    */

    // Check apakah user sudah like video tertentu
    public function hasLiked($videoId)
    {
        return $this->likes()
            ->where('video_id', $videoId)
            ->exists();
    }

    // Get liked videos
    public function getLikedVideos()
    {
        return $this->likes()
            ->with('video')
            ->get()
            ->pluck('video');
    }

    /*
    |--------------------------------------------------------------------------
    | OPTIONAL HELPERS
    |--------------------------------------------------------------------------
    */

    // Profile picture (Gravatar)
    public function getProfilePictureAttribute()
    {
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }

    // Role check
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
