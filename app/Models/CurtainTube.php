<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurtainTube extends Model
{
    public function curtains() {
        return $this->hasMany(CurtainModel::class);
    }

    protected $fillable = ['id','name', 'price'];
}