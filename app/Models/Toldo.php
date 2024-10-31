<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toldo extends Model
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

    public function mechanism() {
        return $this->belongsTo(Mechanism::class);
    }

    public function sensor() {
        return $this->belongsTo(Sensor::class);
    }

    public function voice() {
        return $this->belongsTo(VoiceControl::class);
    }

    public function system() {
        return $this->belongsTo(SistemaToldo::class);
    }

    public function model() {
        return $this->belongsTo(ModeloToldo::class);
    }

    public function handle() {
        return $this->belongsTo(Handle::class);
    }

    protected $fillable = [
        'width',
'projection',
'quantity',
'order_id',
'control_id',
'control_quantity',
'cover_id',
'mechanism_id',
'sistema_toldo_id',
'price',
'canopy',
'sensor_id',
'bambalina',
'voice_id',
        'model_id',
        'handle_id',
        'handle_quantity',
        'voice_quantity',
        'sensor_quantity',
        'accessories_total',
        'systems_total',
        'installation_type',
        'mechanism_side',
        'bambalina_type',
        'inclination'
    ];
}
