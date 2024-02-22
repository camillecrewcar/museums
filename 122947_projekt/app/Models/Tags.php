<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public function threads()
    {
        return $this->belongsToMany(Threads::class, 'tags_threads', 'tag_id', 'thread_id');
    }

}
