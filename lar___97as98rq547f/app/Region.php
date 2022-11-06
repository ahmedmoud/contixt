<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [];
    protected $table = 'regions';
    public $timestamps = false;

    public function Cities()
    {
        return $this->hasMany('App\City');
    }


}