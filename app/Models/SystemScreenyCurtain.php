<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemScreenyCurtain extends Model
{
    public function curtains() {
        return $this->hasMany(ScreenyCurtain::class);
    }
}
