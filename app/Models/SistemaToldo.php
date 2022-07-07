<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemaToldo extends Model
{
    public function toldos() {
        return $this->hasMany(Toldo::class);
    }
}
