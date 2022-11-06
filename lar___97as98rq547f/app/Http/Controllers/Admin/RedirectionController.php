<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use UPerm;
use Auth;
use App\Redirection;

class RedirectionController  extends Controller
{
    
    public function index(){
        $this->perm();
        $redirections = Redirection::paginate(60);
        return view('admin.redirection.index', compact('redirections'));
    }

    public function addRedirection(Request $request){
        $this->perm();
        $this->validate(request(),[
            'fromURL' => 'required|url',
            'toURL' => 'required|url',
        ]); 

        $fromURL = trim(urldecode($request->fromURL));
        $toURL = trim(urldecode($request->toURL));
        $user_id = Auth::user()->id;
        
        $fromURL = parse_url($fromURL);
        $fromURL = $fromURL['path']. ( isset($fromURL['query']) ? '?'.$fromURL['query'] : '' );


        $toURL = parse_url($toURL);
        $toURL = $toURL['path']. ( isset($toURL['query']) ? '?'.$toURL['query'] : '' );

        $fromURL = trim($fromURL,'/');
        $toURL = trim($toURL,'/');

        $body = [
            'fromURL' => $fromURL,
            'toURL' => $toURL,
            'user_id' => $user_id
        ];

        $ex = Redirection::where('fromURL', $fromURL)->first();
        if( $ex ){

            return back()->withErrors(['redirect' => true ])->withInput($request->input());
        }

        Redirection::create($body);
        return redirect('/admin/redirection');

    }


    public function removeRedirection(Request $request, $id){
        $this->perm();
        $redirect = Redirection::where('id', $id)->delete();
        return redirect('/admin/redirection');
    }

    private function perm(){
        if( !\UPerm::manageRedirections() ){
            return abort(404);
        }
    }


}