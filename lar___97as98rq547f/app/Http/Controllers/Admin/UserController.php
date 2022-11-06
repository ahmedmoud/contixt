<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Hash;
use UPerm;
use DB;
use Auth;

class UserController extends Controller
{

    public function editProfile($id){
        $user = User::where('id', $id)->first();
        if( !$user || $user->role_id == null ) return abort(404);
        if( $user->id != Auth::user()->id ) return abort(404);

        return view('admin.users.edit-profile', compact('user') );

    } 

    public function PosteditProfile($id, Request $request){

        $user = User::where('id', $id)->first();
        if( !$user || $user->role_id == null ) return abort(404);
        if( $user->id != Auth::user()->id ) return abort(404);
        
        $body = array();
        if( $user->password != $request->password ) $body['password'] = Hash::make($request->password);
        $body['name'] = $request->name;
        $body['email'] = $request->email;
        
        $out = User::where('id', $id)->update($body);

        return view('admin.users.edit-profile', compact('user') );

    }


    public function RemoveUser($id){
        if(! UPerm::ControlUsers() ){ return UPerm::Block(); }

        $user = User::where('id', $id)->first();
        $users = User::where('id','!=', $id)->where('role_id','!=', null)->get();
        
        return view('admin.users.userRemove', compact('user', 'users') );
    }
public function RemoveUserF($id, Request $request){
    if(! UPerm::ControlUsers() ){ return UPerm::Block(); }

    $user = User::where('id', $id)->first();
    $new  = User::where('id', $request->new_id)->first();

    if( !$user || !$new ){ return 'something went wrong.'; }

    $output = DB::table('posts')->where('user_id',$user->id)->update(['user_id'=> $new->id]);
    $user->delete();
    return redirect(route('users.index'));
}

    public function show(User $user){
        if(! UPerm::ControlUsers() ){ return UPerm::Block(); }
        return dd($user);
    }

    public function outerUsers(){
        if(! UPerm::ControlUsers() ){ return UPerm::Block(); }
        $users = User::whereNull('role_id')->orderBy('created_at','desc')->paginate(30);
        return view('admin.users.index', compact('users'));
    }

    public function index(){
        if(! UPerm::ControlUsers() ){ return UPerm::Block(); }
        $users = User::whereNotNull('role_id')->orderBy('created_at','desc')->select('users.*')->paginate(30);
        return view('admin.users.index', compact('users'));
    }

    public function create(){
        if(! UPerm::ControlUsers() ){ return UPerm::Block(); }

        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request){
        if(! UPerm::ControlUsers() ){ return UPerm::Block(); }

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'role_id' => 'required|integer|exists:roles,id',
            'password' => 'required|min:10'
        ]);

        $body = $request->except('_token');
        $body['password'] = Hash::make($request->password);
        User::create($body);

        return redirect(route('users.index'));
    }
    public function edit(User $user){

        if(! UPerm::ControlUsers() ){ return UPerm::Block(); }


        $roles = Role::all();
        return view('admin.users.create', compact('roles','user'));
    }
    public function update(Request $request, User $user){
        if(! UPerm::ControlUsers() ){ return UPerm::Block(); }


        $body = $request->except(['_token','_method']);

        if( $request->password != $user->password ){
            $body['password'] = Hash::make($request->password);
        }

        $user->update($body);

        return redirect(route('users.index'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(User $user){
        /** @var User $user */

        if(! UPerm::ControlUsers() ){ return UPerm::Block(); }

        $user->delete();
        dd('yes');
        return redirect(route('users.index'));
    }
}
