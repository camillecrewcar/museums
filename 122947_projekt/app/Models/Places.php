<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'coordinates_id', 'code', "description", 'verified'];

    public function coordinates()
    {
        return $this->belongsTo(Coordinates::class);
    }
    public function openingHours()
    {
        return $this->hasMany(OpeningHour::class, 'place_id');
    }
    public function images()
    {
        return $this->hasMany(Images::class, 'places_id');
    }
}
