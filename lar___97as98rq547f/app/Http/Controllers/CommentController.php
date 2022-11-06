<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Auth;
class CommentController extends Controller
{

    public function removeComment(Request $request){
        if( $request->ajax() ){

            $commentID = $request->CommentID;
            $user = ( Auth::check() )? Auth::user() : false;
            if( !$user ) return response()->json(['status'=>false]);

            $comment = Comment::where('id', $commentID)->first();
            if( !$comment ) return response()->json(['status'=>false]);
          
            if( $comment->user_id != $user->id ) return response()->json(['status'=>false]);

            $comment = Comment::where('id', $commentID)->delete();
            if( $comment ) return response()->json(['status'=> true]); 
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax())
                {
                    $this->validate(request(),[
                        'comment' => 'required',
                    ]);
                    $comment = new Comment();
                    $comment->comment = strip_tags($request->comment);
                    $comment->post_id = (int)$request->post_id;
                    $comment->user_id = Auth::check() ? Auth::user()->id : 630;
                    if( !Auth::check() ){
                        $comment->name = strip_tags($request->Cname);
                        $comment->email = strip_tags($request->Cemail);
                    }
                    $comment->save();
                    $html = view('layouts.templates.comment',compact('comment'))->render();
                    return response(['status'=>true,'result'=>$html]);
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
