<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function curtains() {
        return $this->hasMany('App\Models\Curtain');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    protected $fillable = [
        'project',
        'activity',
        'invoice_data',
        'comments',
        'user_id',
        'price',
        'discount',
        'total'
    ];
}