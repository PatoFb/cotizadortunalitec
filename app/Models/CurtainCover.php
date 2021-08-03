<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurtainCover extends Model
{
    public function curtains() {
        return $this->hasMany('App\Models\Curtain');
    }

    public function palillerias() {
        return $this->hasMany(Palilleria::class);
    }

    protected $fillable = [
        'id',
        'name',
        'roll_width',
        'unions',
        'price',
        'photo'
    ];
}
