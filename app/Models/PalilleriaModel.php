<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PalilleriaModel extends Model
{
    public function palillerias() {
        return $this->hasMany(Palilleria::class);
    }
}
