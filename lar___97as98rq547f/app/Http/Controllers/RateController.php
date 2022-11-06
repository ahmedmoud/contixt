<?php

namespace App\Http\Controllers;

use App\Rate;
use Illuminate\Http\Request;
use Auth;

class RateController extends Controller
{
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
            $is_user = Auth::check() ? Auth::user()->id : 'null';
            $rateEx = Rate::where('post_id',$request->post_id)->where('user_id',$is_user)->first();
            if(!$rateEx)
            {
                $rate = new Rate();
                $rate->post_id = $request->post_id;
                $rate->rate = $request->value;
                $rate->user_id = Auth::check() ? Auth::user()->id : 630;
                $rate->save();
                session()->flash('message', 'Thank you For Rating This');
                return response(['status'=>true]);
            }else{
                $rate = Rate::where('post_id',$request->post_id)->where('user_id',$is_user)->update([ 'rate' => $request->value]);
                
                session()->flash('message', 'Thank you For Rating This');
                return response(['status'=>true]);            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function show(Rate $rate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function edit(Rate $rate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rate $rate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rate $rate)
    {
        //
    }
}
