<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = ['thread_id', 'description', 'user_id'];

    public function thread()
    {
        return $this->belongsTo(Threads::class, 'thread_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function like()
    {
        return $this->hasMany(Likes::class, "comment_id");
    }
}
