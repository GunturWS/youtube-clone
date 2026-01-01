<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'video_id', 'content', 'parent_id'];
    
    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relasi untuk komentar balasan
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }
    
    // Relasi ke komentar induk
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    
    // Cek apakah ini komentar balasan
    public function isReply()
    {
        return !is_null($this->parent_id);
    }
}