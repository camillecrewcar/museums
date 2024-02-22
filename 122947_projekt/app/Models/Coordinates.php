<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinates extends Model
{
    protected $table = 'coordinates';

    protected $fillable = ['latitude', 'longitude'];

    public function city()
    {
        return $this->hasOne(Cities::class);
    }
    public function place()
    {
        return $this->hasOne(Places::class);
    }
}
