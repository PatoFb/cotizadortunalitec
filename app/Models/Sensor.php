<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    public function toldos() {
        return $this->hasMany(Toldo::class);

    }

    public function palillerias() {
        return $this->hasMany(Palilleria::class);
    }

}
