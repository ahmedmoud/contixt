<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\MessageBag;
use Validator;
use App\ReCaptcha;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     * 
     * @var string
     */
    protected $redirectTo = '/home'; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return redirect('/admin/login')->withErrors($validator)->withInput();
        }
        $user =
            User::where('username', $request->email)->first() ?
                User::where('username', $request->email)->first() :
                User::where('email', $request->email)->first();
              
        if($user && !$user->role){
        $request->flash();
            $validator->errors()->add('auth', 'This Account Haven\'t A Role');
            return back()->withErrors($validator)->withInput();
        }elseif ($user && Hash::check($request->password, $user->password) ) {
            Auth::login($user);
            return redirect('/admin');
        } else {
            $request->flash();
            $validator->errors()->add('auth', __('auth.failed'));
            return back()->withErrors($validator)->withInput();
        }
    }
    public function logout(){
        if(Auth::check()){
            Auth::logout();
        }
        return redirect('/');
    }
    
    public function post_login(Request $request)
    {  

        
        @session_start();
        $code = @$_SESSION['capCode'];
        $ucode = $request->Input('captcha');

        $remember = $request->Input('rememberMe');
        
        
        if( !$code || trim(strtolower($code)) != trim(strtolower($ucode)) ) return response(['99'=>false]);

        // $reCaptch = new ReCaptcha();
        // $captcha = $reCaptch->validate($request->Input('g-recaptcha-response'));
        // if( !$captcha ){ return response(['status'=>false]); }
        
        if($request->ajax()){

            $validator = Validator::make($request->all(), [
                'email'=>'required',
                'password'=>'required'
            ]);
           
            if($validator->fails()){ 
                return back()->withErrors($validator)->withInput();
            }

            $user =
            User::where('username', $request->email)->first() ?
                User::where('username', $request->email)->first() :
                User::where('email', $request->email)->first();
                
               
            if(!$user){
            	return response(['status'=>false]);
            }elseif($user && Hash::check($request->password, $user->password) ) {
                if( $remember ){
                    Auth::login($user, true);
                }else{

                    Auth::login($user);
                }
                return response(['status'=>true]);
            }
            else
            {
                return response(['status'=>false]);
            } 
        }



    }


}
