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
        return $this->belongsTo(CurtainCover::class);
    }

    public function control() {
        return $this->belongsTo(CurtainControl::class);
    }

    public function mechanism() {
        return $this->belongsTo(CurtainMechanism::class);
    }

    public function reinforcement() {
        return $this->belongsTo(Reinforcement::class);
    }

    protected $fillable = [
        'width',
        'height',
        'quantity',
        'order_id',
        'goals',
        'reinforcement_id',
        'reinforcement_quantity',
        'control_id',
        'control_quantity',
        'cover_id',
        'mechanism_id',
        'price'
    ];
}
