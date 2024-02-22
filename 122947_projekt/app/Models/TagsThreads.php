<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsThreads extends Model
{
    use HasFactory;

    protected $fillable = ['tag_id', 'thread_id'];

    public function tag()
    {
        return $this->belongsTo(Tags::class);
    }
    public function thread()
    {
        return $this->belongsTo(Threads::class);
    }
}
