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

    public function tube() {
        return $this->belongsTo(CurtainTube::class);
    }

    public function panel() {
        return $this->belongsTo(CurtainPanel::class);
    }

    protected $fillable = [
        'name',
        'description',
        'type_id',
        'max_resistance',
        'production_time',
        'max_width',
        'max_height',
        'base_price',
        'photo',
        'tube_id',
        'panel_id'
    ];
}
