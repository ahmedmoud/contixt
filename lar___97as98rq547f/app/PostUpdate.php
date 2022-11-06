<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostUpdate extends Model
{
    protected $table = 'postsupdates';
    protected $fillable = ['user_id','post_id','title','content','date'];
    public $timestamps = false;

    public function author(){
        $a =  $this->hasOne('App\User','id','user_id');
        return $a;
    }

}