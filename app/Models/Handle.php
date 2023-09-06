<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handle extends Model
{
    public function curtains() {
        return $this->hasMany('App\Models\Curtain');
    }

    public function toldos() {
        return $this->hasMany(Toldo::class);
    }

    protected $fillable = ['id','measure', 'price'];
}
