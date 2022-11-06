<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;
use Setting;
use UPerm;
use App\JoinUs;
use App\Role;
use App\User;

class JoinUsController extends Controller 
{
    public function index(){

        $joined = JoinUs::join('users', 'users.id','=','joinUs.user_id')->where('joinUs.status', 1)->whereNotNull('users.role_id')->count();
        $pending = JoinUs::where('status', 0)->count();
        $rejected = JoinUs::where('status', 3)->count();

        $posts = JoinUs::paginate(30);

        return view('admin.joinUs.index', compact('joined','pending','rejected','posts') );
    }
    public function view($id){
        $order = JoinUs::where('id', $id)->first();
        $order->data = json_decode($order->data);
        $roles = Role::all();
        return view('admin.joinUs.view', compact('order','roles') );
    }
    public function reject(Request $request){
        $body = $request->except('_token');
        $user = new User;
        $user = $user->where('id', $request->user_id);
        $user->update(['role_id'=> null ]);

        $order = JoinUs::where('id', $request->id )->update(['reason'=> $request->reason, 'status'=> 3 ]);
        return redirect('/admin/joinUs');
    }

    public function accept(Request $request){
        $body = ['role_id'=> $request->role_id];
        $user = new User;
        $user = $user->where('id', $request->user_id);
        $user->update($body);
        $order = JoinUs::where('id', $request->order_id )->update(['status'=> 1 ]);
        return redirect('/admin/joinUs');
    }

}
