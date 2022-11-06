<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['action', 'section'];
    protected $appends = [];

    public function roles(){
        return $this->belongsToMany('App\Role','role_permission');
    }
    
}
