<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ✅ TAMBAHKAN RELASI KE LIKE
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // ✅ TAMBAHKAN RELASI KE SUBSCRIPTION
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'subscriber_id');
    }

    // ✅ CHECK APAKAH USER SUDAH LIKE VIDEO TERTENTU
    public function hasLiked($videoId)
    {
        return $this->likes()->where('video_id', $videoId)->exists();
    }

    // ✅ CHECK APAKAH USER SUDAH SUBSCRIBE CHANNEL TERTENTU
    public function hasSubscribed($channelId)
    {
        return $this->subscriptions()->where('channel_id', $channelId)->exists();
    }

    // ✅ GET LIKED VIDEOS (untuk profile page)
    public function getLikedVideos()
    {
        return $this->likes()->with('video')->get()->pluck('video');
    }

    // ✅ GET SUBSCRIBED CHANNELS (untuk profile page)
    public function getSubscribedChannels()
    {
        return $this->subscriptions()->get();
    }

    // ✅ OPTIONAL: TAMBAHKAN ATTRIBUTE PROFILE PICTURE
    public function getProfilePictureAttribute()
    {
        // Gunakan gravatar atau upload custom
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }

    // ✅ OPTIONAL: TAMBAHKAN ROLE JIKA PERLU (user/admin)
    public function isAdmin()
    {
        return $this->role === 'admin'; // tambah kolom 'role' di tabel users jika perlu
    }
}