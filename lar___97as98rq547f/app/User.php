<?php

namespace App;

use App\Presenters\User\UrlPresenter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $appends = ['url'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password','role_id','provider_id','provider','cat' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function posts(){
        return $this->hasMany('App\Post');
    }



    public function permissions(){
//        return $this->role();
if($this->role){
        return @$this->role->permissions() ?? null;
        }else{
        	return null;
        }
    }

    public function hasPermission($action, $section){
    if($this->permissions()){
        return $this->permissions()->whereAction($action)->whereSection($section)->count() ?? false;
        }else{
        return null;
        }
    }

     public function comment(){
        return $this->hasMany('App\Comment');
    }


    public function getUrlAttribute(){
        return new UrlPresenter($this);
    }

    public function deletionForm($text='Delete'){
        $output = '';
        $output .= '<form action="' . $this->url->destroy . '" style="display: inline;" method="post">';
        $output .= csrf_field();
        $output .= '<input type="hidden" name="_method" value="DELETE" />';
        $output .= '<button type="submit" class="btn btn-danger">';
        $output .= $text;
        $output .= '</button></form>';

        return $output;
    }
}
