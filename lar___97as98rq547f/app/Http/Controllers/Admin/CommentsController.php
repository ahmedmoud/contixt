<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;
use Setting;
use UPerm;


class CommentsController extends Controller 
{
    public function index(){
        if(! UPerm::ControlComments() ){ return UPerm::Block();  }
        $comments = Comment::orderBy('created_at','desc')->paginate(20);
        // dd( $comments[0]->post->slug );
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){
        if(! UPerm::ControlComments() ){ return UPerm::Block();  }

        $id = $request->commentID;
        $value = $request->how;

        $value = ( $value > 0 )? 1 : 0;

        $comment = Comment::where('id', $id)->update(['status'=> $value]);
        return back();
    }

    public function destroy(Request $request){
        if(! UPerm::ControlComments() ){ return UPerm::Block();  }

        $id = $request->commentID;
        $comment = Comment::where('id', $id)->delete();
        return back();
    }
}
