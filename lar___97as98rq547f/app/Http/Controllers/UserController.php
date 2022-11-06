<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Job;
use Redirect;
use Input;
use Image;
use App\Country;


class UserController extends Controller
{
    public function lessInfo(){
        if( !Auth::check() || !Auth::user()->id ){ return redirect( url('/') ); }
        $countries = Country::get();
        $jobs = Job::get();
        return view('layouts.moreInfo', compact('countries','jobs') );
    }
    public function moreInfo(Request $request){
    
        $this->validate(request(),[
            'job_id' => 'required|min:1',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'mobile' => 'required|min:6',
            'img'    => 'required'
        ]);

        if( !Auth::check() || !Auth::user()->id ) return Redirect::back()->withErrors(['msg'=>'يرجى تسجيل الدخول أولاً']);

        $file       = $request->file('img');
        $extension = $file->getClientOriginalExtension();
        $fileNAME    = $file->getClientOriginalName();
        $filename = time().'.'.$extension;
        $mime = $request->img->getClientMimeType();
        if(substr($request->img->getClientMimeType(), 0, 5) == 'image') {
            $type = 'img';
            $image = $file;
            list($width, $height) = getimagesize($request->img);
            $image_resize = Image::make($image->getRealPath());
            if( $width > 900 ){
                $image_resize->resize(900, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }
        $imgName = 'uploads/users/'.$filename;
        $image_resize->save(public_path($imgName));
        $imgName = 'uploads/users/'.$filename;


        $body = $request->except('_token','return');
        $body['img'] = $imgName;

        if( !Job::where('id', $body['job_id'])->first() ) return Redirect::back()->withErrors(['msg'=>'حدث خطأ ما ، يرجى المحاولة لاحقاً']);

        $user = User::where('id', Auth::user()->id )->update($body);
        if( $request->return ) return redirect( url( $request->return ) );
        
        // redirect to user profile...
        return redirect( '' );

    }

}