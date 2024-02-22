<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'coordinates_id'];

    public function coordinates()
    {
        return $this->belongsTo(Coordinates::class);
    }
}
