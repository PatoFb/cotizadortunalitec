<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurtainCover extends Model
{
    public function curtains() {
        return $this->hasMany('App\Models\Curtain');
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
