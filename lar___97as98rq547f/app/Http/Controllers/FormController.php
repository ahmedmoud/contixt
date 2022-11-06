<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;


class FormController extends Controller
{

    public function contactGet(){
        $data = Collect();
        $data->title = 'اتصل بنا';
        $data->slug = 'اتصل-بنا';
        $data->type = 'اتصل بنا';
    
        return view('layouts.forms.contact', compact('data'));
    }

    public function advertiseGet(){
        $data = Collect();
        $data->title = 'أعلن معنا';
        $data->slug = 'أعلن-معنا';
        $data->type = 'أعلن معنا';
    
        return view('layouts.forms.contact', compact('data'));
    }

    public function sendForm(Request $request){
        
        $this->validate(request(),[
            'name' => 'required',
            'phone' => 'required',
            'subject' => 'required',
            'email' => 'required',
            'message' => 'required',
            'captcha'  => 'required'
        ]);        

        @session_start();
        $code = @$_SESSION['capCode'];
        $ucode = $request->Input('captcha');
        if( !$code || trim(strtolower($code)) != trim(strtolower($ucode)) )  return Redirect::back()->withErrors(['msg'=>'الكود المطابق للصورة غير صحيح']); 
        
        $body = $request->except('_token','captcha');
        $output = '';
        foreach($body as $key=>$value ){
            $output .= "<b>".$key."</b>".' : '.$value."\n <br/>";
        }
        //$headers = "MIME-Version: 1.0" . "\r\n";
        $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
        //$headers .= "From: admin@setaat.com" . "\r\n";
        
        $to = 'info@setaat.com';
        $subject = "Setaat Forms: ".$request->subject;
        if( mail($to, $subject, $output, $headers) ){
            return Redirect::back()->withErrors(['success'=>'تم الإرسال بنجاح ، سيتم التواصل معكم في أقرب وقت.']); 
        }else{
            return Redirect::back()->withErrors(['msg'=>'حدث خطأ ما ، يرجى المحاولة لاحقاً.']); 

        }


    }

    public function BMIView(){
        return view('layouts.forms.BMI');
    }

    public function BMICalc(){
        dd( 'asdf') ;
    }

    



}