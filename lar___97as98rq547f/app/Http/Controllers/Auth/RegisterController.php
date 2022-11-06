<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Auth;
use App\ReCaptcha;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
    
	return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'cat' => 'nullable',
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => setting('default-role'),
            'password' => Hash::make($data['password']),
            'cat' => $data['cat'],
            'notifications' => isset($data['notifications']) && $data['notifications'] ? 1 : ''
        ]);
    }
    
    public function post_register(Request $request)
    {
        
        if($request->ajax()){

            // $reCaptch = new ReCaptcha();
            // $captcha = $reCaptch->validate($request->Input('g-recaptcha-response'));
            // if( !$captcha ){ return response(['status'=>false]); }
            
            @session_start();
            $code = @$_SESSION['capCode'];
            $ucode = $request->Input('captcha');
            if( !$code || trim(strtolower($code)) != trim(strtolower($ucode)) ) return response(['99'=>false]);


            $validator = $this->validator($request->all());
        
            if($validator->fails()){
                return response(['status'=>false]);
               // return back()->withErrors($validator)->withInput();
            }
            else{
                $body = $request->all();

                if( isset($request->categories) && is_array($request->categories) && count($request->categories) > 0 ){
                    $allCats = \App\Category::select('id')->pluck('id')->toArray();
                    $vArr = [];
                    foreach( $request->categories as $aCat ){
                        if( !in_array($aCat, $allCats) ) continue; 

                        $vArr[] = $aCat;

                    }
                   
                    if( count($vArr) > 0 ){
                        $body['cat'] = json_encode($vArr);
                    }
                }

                $body['cat'] = isset($body['cat']) ? $body['cat'] : '';
                $body['notifications'] = isset($body['notifications']) && $body['notifications']  == '1' ? 1 : 0;
                $user = $this->create($body); 

                Auth::login($user);
                return response(['status'=>true]);
            }
        }
    }
    
	public function register(Request $request){
		$validator = $this->validator($request->all());
		if(!setting('default-role')){
		$validator->errors()->add('role', 'Something Went Wrong');
		}
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }
            else{
            	return redirect('/');
		}
		}
}
