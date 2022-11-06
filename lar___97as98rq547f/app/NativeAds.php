<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NativeAds extends Model
{
    public $timestamps = false;
    protected $table = 'nativeads';

    protected $fillable = ['title','widget_id','ord','pid','data','status'];

    
}