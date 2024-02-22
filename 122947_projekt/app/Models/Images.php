<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    protected $fillable = ['source_url', 'places_id'];

    public function place()
    {
        return $this->belongsTo(Places::class, 'places_id');
    }
}
