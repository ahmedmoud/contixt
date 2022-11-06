<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipes_Types extends Model
{
    public $timestamps = false;
    
    protected $table = 'recipes_types';
    protected $fillable = ['type','name','order'];

    
    public function recipes(){
        return $this->belongsToMany('App\Recipe','recipe_type','type_id','recipe_id');
    }


}