<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opinions extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'place_id', 'score', "description"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function place()
    {
        return $this->belongsTo(Places::class);
    }
}
