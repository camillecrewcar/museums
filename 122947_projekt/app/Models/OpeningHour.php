<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningHour extends Model
{
    protected $fillable = ['place_id', 'day_of_week', 'opening_time', 'closing_time'];

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id' );
    }
}
