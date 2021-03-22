<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curtain extends Model
{
    public function curtain_model() {
        return $this->belongsTo('App\Models\CurtainModel');
    }

    public function order() {
        return $this->belongsTo('App\Models\Orden');
    }

    public function cubierta() {
        return $this->belongsTo('App\Models\CurtainCover');
    }

    public function manivela() {
        return $this->belongsTo('App\Models\CurtainHandle');
    }

    public function control() {
        return $this->belongsTo('App\Models\CurtainControl');
    }

    public function tejadillo() {
        return $this->belongsTo('App\Models\CurtainCanopy');
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
        'price'
    ];
}
