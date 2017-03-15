<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $hidden = array('password', 'remember_token');
    protected $fillable = ['email', 'username', 'password', 'firts_name', 'last_name'];

    
    public function comments() {
        return $this->hasMany('App\Models\Comment');
    }
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
}
