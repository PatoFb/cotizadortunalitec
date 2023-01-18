<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenyCurtain extends Model
{
    public function model() {
        return $this->belongsTo('App\Models\CurtainModel');
    }

    public function order() {
        return $this->belongsTo('App\Models\Orden');
    }

    public function cover() {
        return $this->belongsTo('App\Models\Cover');
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

    public function system() {
        return $this->belongsTo(SystemCurtain::class);
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
        'mechanism_id',
        'installation_type',
        'mechanism_side',
        'view_type',
        'voice_id',
        'sensor_id',
        'sensor_quantity',
        'voice_quantity',
        'handle_quantity',
        'control_quantity'
    ];
}
