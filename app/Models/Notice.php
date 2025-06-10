<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'title',
        'type',
        'message',
        'cover_id',
        'is_active',
    ];

    public function cover() {
        return $this->belongsTo(Cover::class);
    }
}
