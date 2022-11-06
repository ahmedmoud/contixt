<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\Post\UrlPresenter;
use DB;

require_once  __DIR__.'/simple_html_dom.php';


class Post extends Model
{
    protected $appends = ['url'];
    protected $casts = ['comment_status' => 'boolean'];
    protected $fillable = ['seoStatus','dob','lang','focuskw','title','type', 'content','excerpt', 'slug', 'status','image','user_id', 'comment_status','created_at','updated_at','notes','refrences','RelatedPosts'];
    public $timestamps = false;

    public function categories(){
        return $this->belongsToMany('App\Category');
    }
    public function tags(){
        return $this->belongsToMany('App\Tag');
    }
    public function author(){
        return $this->belongsTo('App\User', 'user_id');
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    public function recipe(){
        return $this->hasOne('App\Recipe');
    }
    public function categoriesHTML(){
        $output = '';
        $categories = $this->categories()->get();
        if($categories->count()){
            foreach($categories as $key => $category){

                $output .= '<a target="_blank" href="'. asset($category->slug) .'">' . $category->name .'</a>';
                if($key != $categories->count() - 1){
                    $output .= ' - ';
                }
            }
        }else{
            $output = 'ـــ';
        }


        return $output;
    }

    public function tagsHTML(){
        $output = '';
        $tags = $this->tags()->get();
        if($tags->count()){
            foreach($tags as $key => $tag){
                $output .= '<a href="'. $tag->slug .'">'. $tag->name .'</a>';
                if($key != $tags->count() - 1){
                    $output .= ' - ';
                }
            }
        }else{
            $output = 'ـــ';
        }


        return $output;
    }

    public function getUrlAttribute(){
        return new UrlPresenter($this);
    }

    public function ActivationForm($disableText ='Disable', $enableText = 'Enable'){
        $output = '';
        $output .= '<form action="'. $this->url->update .'" style="display: inline;" method="post">';
        $output .= csrf_field();
        $output .= '<input type="hidden" name="_method" value="PUT">';
        $output .= '<input type="hidden" name="status" value="'.($this->status == 1 ? 0 : 1). '">';
        $output .= '<button type="submit" class="btn ';
        if($this->status){
           $output .= 'btn-warning';
        }else{
            $output .= 'btn-success';
        }
        $output .= '">';
        if($this->status){
            $output .= $disableText;
        }else{
            $output .= $enableText;
        }
        $output .= '</button>';
        $output .= '</form>';
        return $output;
    }

    public function deletionForm($text='Delete'){
        $output = '';
        $output .= '<form onclick="'."return confirm('هل متأكدة من حذفك لهدا المقال؟');".'" action="' . $this->url->destroy . '" style="display: inline;" method="post">';
        $output .= csrf_field();
        $output .= '<input type="hidden" name="_method" value="DELETE" />';
        $output .= '<button type="submit" class="btn btn-danger">';
        $output .= $text;
        $output .= '</button></form>';

        return $output;
    }

    public function setCommentStatusAttribute($value){
        $values = ['on' => 1, 'off' => 0];

        if(!is_numeric($value)){
            $this->attributes['comment_status'] =  $values[$value];
        }
    }
    public function rates()
    {
        return $this->hasMany('App\Rate');
    }

    public function NUpdates(){
        return $this->hasMany('App\PostUpdate','post_id')->count();
    }

    public function likes()
    {
        return $this->hasMany('App\Like','item_id');
    }

    public function favourites()
    {
        return $this->hasMany('App\Favourite');
    }


}
