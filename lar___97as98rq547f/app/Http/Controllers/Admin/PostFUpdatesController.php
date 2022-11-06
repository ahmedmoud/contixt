<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PostUpdate;
use App\Post;
use Auth;
use UPerm;

class PostFUpdatesController extends Controller
{

    private function perm($post_user_id = false ){
        $aPost = Post::where('id', $post_user_id)->select('user_id')->first();
        if( !$aPost ) abort(404);
        $post_user_id = $aPost->user_id;

        $theUserID = Auth::user()->id;
        $perm =  UPerm::ControlPostsFUpdates() || ( UPerm::ControlHisPostsFUpdates() && ( $theUserID == $aPost->user_id || ( $theUserID == 869 && $aPost->user_id == 999 ) ) );
        if( !$perm ) abort(404);
    }

    public function getAllFupdates(){
        if( !UPerm::ControlPostsFUpdates()  ) abort(404);

        $updates = PostUpdate::select('posts.id as pID','posts.title as ptitle','posts.slug as pslug','postsUpdates.id','postsUpdates.title','postsUpdates.date','users.name')->join('users','users.id','=','postsUpdates.user_id')->join('posts','posts.id','postsUpdates.post_id')->orderBy('postsUpdates.id','desc')->paginate(60);
        $render = true;
        return view('admin.posts.postUpdate', compact('updates','post','render'));

    }
    public function getUpdates($id){
        $this->perm($id);
        $post = Post::where('id', $id)->first();
        if( !$post ) abort(404);

        $updates = PostUpdate::select('postsUpdates.id','postsUpdates.title','postsUpdates.date','users.name')->join('users','users.id','=','postsUpdates.user_id')->where('post_id', $id)->paginate(60);
        $render = true;
        return view('admin.posts.postUpdate', compact('updates','post','render'));
    }

    public function addUpdate($id){
        $this->perm($id);
        $post = Post::where('id', $id)->first();
        if( !$post ) abort(404);
        return view('admin.posts.postFUpdate', compact('post'));
    }

    public function saveUpdates($id, Request $request){
        $this->perm($id);
        $this->validate(request(),[
            'title' => 'required|min:3',
            'content'  => 'required|min:3',
            'date'  => 'required',
        ]); 

        $post = Post::where('id', $id)->first();
        if( !$post ) abort(404);

        $body = $request->except('_token');
        $body['user_id'] = Auth::user()->id;
        $body['post_id'] = $id;

        PostUpdate::create($body);

        return redirect('/admin/future-updates/'.$id);

    }
    public function editUpdate($id){
        $update = PostUpdate::where('id', $id)->first();
        $this->perm($update->post_id);
        if( !$update ) abort(404);

        $post = Post::where('id', $update->post_id)->first();
        if( !$post ) abort(404);

        return view('admin.posts.postFUpdate', compact('post','update'));

    }

    public function SaveEditUpdate($id, Request $request){

        $this->validate(request(),[
            'title' => 'required|min:3',
            'content'  => 'required|min:3',
            'date'  => 'required',
        ]); 
        $update = PostUpdate::where('id', $id)->first();

        if( !$update ) abort(404);
        $this->perm($update->post_id);

        $body = $request->except('_token');
        $update->update($body);
        return redirect('/admin/future-updates/'.$update->post_id);
    }

    public function delete($id, Request $request){
        $update = PostUpdate::where('id', $id)->first();
        $this->perm($update->post_id);

        if( !$update ) abort(404);

        $update->delete();
        return redirect('/admin/future-updates/'.$update->post_id);
    }
}