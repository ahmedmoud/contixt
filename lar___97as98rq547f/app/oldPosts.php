<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class oldPosts extends Model
{
    protected $fillable = ['title','content','excerpt','image','focuskw','slug','type','post_id','user_id'];
    protected $table = 'oldposts';



    public function author(){
        return $this->belongsTo('App\User', 'user_id');
    }

}