<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Traits\HaveAdminButtonsForms;
class Resala extends Model
{
    protected $fillable = ['title', 'link','user_id','created_at','status'];
    protected $table = 'resala';
    public $timestamps = false;

    public function user(){
        return $this->hasOne('App\User','id','user_id')->select('id','name','username');
    }
    public function author(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function deletionForm($text='Delete'){
        $output = '';
        $output .= '<form onclick="'."return confirm('هل متأكدة من الحذف؟');".'" action="' . url('admin/resala/'.$this->id) . '" style="display: inline;" method="post">';
        $output .= csrf_field();
        $output .= '<input type="hidden" name="_method" value="DELETE" />';
        $output .= '<button type="submit" class="btn btn-danger">';
        $output .= $text;
        $output .= '</button></form>';

        return $output;
    }

    function ArabicDate() {
        $date = \Carbon::createFromFormat($this->created_at);
        return $date;
        $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");
        $your_date = date('y-m-d'); // The Current Date
        $en_month = date("M", strtotime($your_date));
        foreach ($months as $en => $ar) {
            if ($en == $en_month) { $ar_month = $ar; }
        }
    
        $find = array ("Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri");
        $replace = array ("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        $ar_day_format = date('D'); // The Current Day
        $ar_day = str_replace($find, $replace, $ar_day_format);
    
        header('Content-Type: text/html; charset=utf-8');
        $standard = array("0","1","2","3","4","5","6","7","8","9");
        $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
        $current_date = $ar_day.' '.date('d').'  '.$ar_month.'  '.date('Y');
        $arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);
    
        return $arabic_date;
    }


}