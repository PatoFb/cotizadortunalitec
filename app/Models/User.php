<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rfc',
        'cfdi',
        'phone',
        'discount',
        'state',
        'city',
        'zip_code',
        'line1',
        'line2',
        'reference',
        'role_id',
        'partner_id',
        'restricted'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role() {
        return $this->belongsTo('App\Models\Role');
    }

    public function partner() {
        return $this->belongsTo('App\Models\Partner');
    }

    public function isAdmin(){
        if($this->role_id == 1){
            return true;
        }
        return false;
    }

    public function client(){
        if($this->role_id == 2){
            return true;
        }
        return false;
    }

    public function unauthorized(){
        if($this->role_id == 3){
            return true;
        }
        return false;
    }

    public function orders() {
        return $this->hasMany('App\Models\Order');
    }
}
