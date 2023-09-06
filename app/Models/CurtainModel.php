<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurtainModel extends Model
{
    public function curtains() {
        return $this->hasMany('App\Models\Curtain');
    }

    public function type() {
        return $this->belongsTo('App\Models\Type');
    }


    protected $fillable = [
        'name',
        'description',
        'type_id',
        'max_resistance',
        'production_time',
        'max_width',
        'max_height'
    ];
}
