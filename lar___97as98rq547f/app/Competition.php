<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Competition extends Model
{

    protected $table = 'competitions';
    protected $fillable = ['title', 'content','excerpt', 'slug', 'status','image','user_id', 'comment_status'];
    
        public function user(){
            return $this->hasOne('App\User','id','user_id')->select('id','name','username');
        }
        public function author(){
            return $this->belongsTo('App\User', 'user_id');
        }
    public function comments(){
        return $this->hasMany('App\competitionsComments','id','comp_id');
    }

    
    public function deletionForm($text='Delete'){
        $output = '';
        $output .= '<form onclick="'."return confirm('هل متأكدة من حذفك لهدا المقال؟');".'" action="' . url('admin/competitions/'.$this->id) . '" style="display: inline;" method="post">';
        $output .= csrf_field();
        $output .= '<input type="hidden" name="_method" value="DELETE" />';
        $output .= '<button type="submit" class="btn btn-danger">';
        $output .= $text;
        $output .= '</button></form>';
        return $output;
    }





    public function post(){
        return $this->hasOne('App\Post','id','post_id')->select('id','slug','title');
    }
}
