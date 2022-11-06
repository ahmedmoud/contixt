<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [];
    protected $table = 'countries';
    public $timestamps = false;

    public function Regions()
    {
        return $this->hasMany('App\Region');
    }


}