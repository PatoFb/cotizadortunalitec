<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloToldo extends Model
{
    protected $fillable = [
        'name',
        'description',
        'wind_resistance',
        'production_time',
        'max_width',
        'min_width',
        'photo'
    ];

    public function toldos() {
        return $this->hasMany(Toldo::class);
    }
}
