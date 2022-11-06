<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Traits\HaveAdminButtonsForms;
class Category extends Model
{
	use HaveAdminButtonsForms;
    protected $fillable = ['lang','name', 'slug', 'parent_id', 'level', 'status','color','description'];

	public function updateUrl(){
		return '/admin/categories/' . $this->id;
	}
    public function posts(){
        return $this->belongsToMany('App\Post');
    }
    public function parent()
    {
        return $this->belongsTo('App\Category');
    }

    public function children(){
        return $this->hasMany('App\Category','parent_id','id');
    }

    public function hasChildren(){
        if($this->children->count()){
            return true;
        }

        return false;
    }
    
    public function parentC()
    {
        return $this->belongsTo('App\Category','parent_id','id')->select('id','parent_id','slug','name');
    }



    
    public function getParents()
    {
        $parents = collect([]);
        
        $parent = $this->parentC;
        
	    while(!is_null($parent)) {
	        $parents->push($parent);
            $parent = $parent->parentC;
        }
	    return $parents;
   }
}
