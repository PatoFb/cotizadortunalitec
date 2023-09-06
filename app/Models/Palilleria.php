<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Palilleria extends Model
{
    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function cover() {
        return $this->belongsTo(Cover::class);
    }

    public function control() {
        return $this->belongsTo(Control::class);
    }

    public function voice() {
        return $this->belongsTo(VoiceControl::class);
    }

    public function sensor() {
        return $this->belongsTo(Sensor::class);
    }

    public function mechanism() {
        return $this->belongsTo(Mechanism::class);
    }

    public function model() {
        return $this->belongsTo(PalilleriaModel::class);
    }

    protected $fillable = [
        'width',
        'height',
        'quantity',
        'order_id',
        'model_id',
        'guide',
        'guide_quantity',
        'control_id',
        'control_quantity',
        'cover_id',
        'mechanism_id',
        'price',
        'sensor_id',
        'sensor_quantity',
        'trave',
        'semigoal',
        'goal',
        'trave_quantity',
        'semigoal_quantity',
        'goal_quantity',
        'voice_id',
        'voice_quantity'
    ];
}
