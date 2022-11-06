<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $appends = ['isActive', 'isDisabled'];
    protected $fillable = ['name', 'status'];

    public function getIsActiveAttribute(){
        return $this->attributes['status'] == 1;
    }

    public function getIsDisabledAttribute(){
        return $this->attributes['status'] == 0;
    }

    public function permissions(){
            return $this->belongsToMany('App\Permission', 'role_permission')->withPivot('status')->wherePivot('status', 1);
    }
    public function withDisabledPermissions(){
        return $this->belongsToMany('App\Permission', 'role_permission')->withPivot('id','status');
    }

    public function hasPermission($permission){
        return $this->permissions()->where('name', $permission)->count() ?? false;
    }
}
