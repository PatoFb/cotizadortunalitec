<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurtainHandle extends Model
{
    public function curtains() {
        return $this->hasMany('App\Models\Curtain');
    }

    protected $fillable = ['id','measure', 'price'];
}
