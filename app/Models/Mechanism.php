<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanism extends Model
{
    public function curtains() {
        return $this->hasMany(Curtain::class);
    }

    public function palillerias() {
        return $this->hasMany(Palilleria::class);
    }

    public function toldos() {
        return $this->hasMany(Toldo::class);
    }

    protected $fillable = ['id','name', 'price'];
}
