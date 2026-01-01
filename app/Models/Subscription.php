<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id', 
        'channel_id', 
        'channel_name', 
        'channel_thumbnail'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk mendapatkan subscription user tertentu
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}