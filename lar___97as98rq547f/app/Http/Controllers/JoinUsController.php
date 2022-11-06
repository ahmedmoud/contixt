<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use UPerm;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Illuminate\Support\Facades\Validator;
use App\JoinUs;

class JoinUsController extends Controller
{
    public function join(){
        $is_there = false;
        if( Auth::check() ) $is_there = JoinUs::where('user_id', Auth::user()->id)->first();
        return view('layouts.forms.joinUs', compact('is_there'));
    }

    public function post(Request $request){

        if( !Auth::check() || !Auth::user()->id ) return Redirect::back()->withErrors(['msg'=>'يرجى تسجيل الدخول أولاً']);
        
        $this->validate(request(),[
            'experience' => 'required',
            'files'  => 'max:3000'
        ]);
        
        if( !$request->file('files') && !$request->oldURLs ) return Redirect::back()->withErrors(['msg'=>'يرجى إضافة بعض الروابط او رفع بعض الاعمال.']);
        $data = [];

        if( $request->experience ){ $data['experience'] = $request->experience; }
        if( $request->oldURLs ){ $data['oldURLs'] = $request->oldURLs; }
        if( $request->notice ){ $data['notice'] = $request->notice; }
        
        if( $request->file('files') ){
            $count = count( $request->file('files') );
            $input_data = $request->all();
            $validator = Validator::make(
                $input_data, [
                'files.*' => 'required|mimes:docx,pdf|max:2000'
                ],[
                    'files.*.required' => 'Please upload an image',
                    'files.*.mimes' => 'Only jpeg,png and bmp images are allowed',
                    'files.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
                ]
            );
            if ($validator->fails()) {
                return Redirect::back()->withErrors(['msg'=>'هناك خطأ ما بالملفات المرفوعة.']);
            }else{
                foreach( $request->file('files') as $file ){

                    $name = $file->getClientOriginalName();
                    $ex = $file->getClientOriginalExtension();
                    $name = rand(10,100).time().'.'.$ex;
                    $file->move(public_path().'/uploads/joinUs/', $name);  
                    $data['files'][] = 'uploads/joinUs/'.$name;
                }
            }
        }
      
        $data = json_encode($data);

        $body = ['data'=>$data, 'user_id'=>Auth::user()->id, 'status'=>0];
        $join = JoinUs::create($body);

        return Redirect::back()->withErrors(['success'=>'تم إرسال طلبكم بنجاح ، سيتم التواصل معكم في أقرب وقت.']);

    }



}