<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Comment extends Model
{
    protected $fillable = ['comment','user_id','post_id','name','email'];
    
    public function user(){
        return $this->hasOne('App\User','id','user_id')->select('id','name','username');
    }

    public function post(){
        return $this->hasOne('App\Post','id','post_id')->select('id','slug','title');
    }

}
