<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class competitionsComments extends Model
{
	protected $fillable = ['comment','user_id','sub_id'];
    public function user(){
        return $this->hasOne('App\User','id','user_id')->select('id','name','username');
    }

    public function competition(){
        return $this->hasOne('App\Competition','id','comp_id')->select('id','slug','title');
    }
}
