<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curtain extends Model
{
    public function model() {
        return $this->belongsTo('App\Models\CurtainModel');
    }

    public function order() {
        return $this->belongsTo('App\Models\Orden');
    }

    public function cover() {
        return $this->belongsTo('App\Models\CurtainCover');
    }

    public function handle() {
        return $this->belongsTo('App\Models\CurtainHandle');
    }

    public function control() {
        return $this->belongsTo('App\Models\CurtainControl');
    }

    public function canopy() {
        return $this->belongsTo('App\Models\CurtainCanopy');
    }

    public function mechanism() {
        return $this->belongsTo(CurtainMechanism::class);
    }

    protected $fillable = [
        'order_id',
        'quantity',
        'model_id',
        'width',
        'height',
        'cover_id',
        'handle_id',
        'control_id',
        'canopy_id',
        'price',
        'mechanism_id'
    ];
}
