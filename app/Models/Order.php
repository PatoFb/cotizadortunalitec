<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function curtains() {
        return $this->hasMany('App\Models\Curtain');
    }

    public function screenies() {
        return $this->hasMany('App\Models\ScreenyCurtain');
    }

    public function palillerias() {
        return $this->hasMany(Palilleria::class);
    }

    public function toldos() {
        return $this->hasMany(Toldo::class);
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    protected $fillable = [
        'project',
        'activity',
        'comments',
        'user_id',
        'price',
        'discount',
        'total',
        'state',
        'city',
        'zip_code',
        'line1',
        'line2',
        'reference'
    ];
}
