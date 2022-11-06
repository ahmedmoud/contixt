<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionSub extends Model
{
    protected $fillable = ['comp_id','user_id','data'];
    protected $table = 'competitions_subs';

    public function author(){
        return $this->belongsTo('App\User', 'user_id');
    }
    public function comments(){
        return $this->hasMany('App\competitionsComments', 'sub_id');
    }
    public function votes(){
        return $this->hasMany('App\CompetitionVotes', 'sub_id');
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

}