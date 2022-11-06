<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Traits\HaveAdminButtonsForms;
class Recipe extends Model
{
    protected $fillable = ['post_id','recipeName','ingredient' ,'instructions' ,'calories' ,'cookTime' ,'prepTime' ,'cuisine' ,'recipeType' ,'yield' ,'cookMethod' ,'diet' ,'videoURL' ,'videoThumbnail','fatContent','protein','notice','difficulty','mid_img','carbohydrates'];

    public function types(){
        return $this->belongsToMany('App\Recipes_Types','recipe_type','recipe_id','type_id');
    }

    public function cuisine(){
        return $this->types()->where('type','cuisine');
    }


}