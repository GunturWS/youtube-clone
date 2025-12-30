<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['subscriber_id', 'channel_id'];
    
    public function subscriber()
    {
        return $this->belongsTo(User::class, 'subscriber_id');
    }
}