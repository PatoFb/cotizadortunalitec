<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function curtain_models(){
        return $this->hasMany('App\Models\CurtainModel');
    }

    protected $fillable = ['id','name'];
}
