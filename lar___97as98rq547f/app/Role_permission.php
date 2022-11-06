<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_permission extends Model
{
    public $timestamps = false;
    protected $table = 'role_permission';
    protected $fillable = ['role_id','permission_id','status'];
}
