<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comments;


class Threads extends Model
{
    use HasFactory;

    protected $fillable = ['Title', 'user_id', "description"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'tags_threads', 'thread_id', 'tag_id');
    }
    public function comments()
    {
        return $this->hasMany(Comments::class, 'thread_id');
    }
}
