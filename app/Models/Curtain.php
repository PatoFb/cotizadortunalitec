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
        return $this->belongsTo('App\Models\Cover');
    }

    public function handle() {
        return $this->belongsTo('App\Models\Handle');
    }

    public function control() {
        return $this->belongsTo('App\Models\Control');
    }

    public function mechanism() {
        return $this->belongsTo(Mechanism::class);
    }

    public function voice() {
        return $this->belongsTo(VoiceControl::class);
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
        'canopy',
        'price',
        'mechanism_id',
        'installation_type',
        'mechanism_side',
        'view_type',
        'voice_id',
        'voice_quantity',
        'handle_quantity',
        'control_quantity'
    ];
}
