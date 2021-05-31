<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurtainMechanism extends Model
{
    public function curtains() {
        return $this->hasMany(Curtain::class);
    }

    protected $fillable = ['id','name', 'price'];
}
