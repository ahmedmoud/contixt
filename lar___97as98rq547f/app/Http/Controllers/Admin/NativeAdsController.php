<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\NativeAds;
use Auth;
use Http;
use UPerm;
use DB;

class NativeAdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(! UPerm::ControlNativeAds() ){ return UPerm::Block(); }
        $Ads = NativeAds::groupBy('pid')->orderBy('NativeAds.id','Desc')->paginate(20);

        return view('admin.NativeAds.index')->withAds($Ads);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(! UPerm::ControlNativeAds() ){ return UPerm::Block(); }
    
        $widgets = DB::table('sidebars_widgets')->join('sidebars','sidebars.id','=','sidebars_widgets.sidebar_id')->select('sidebars_widgets.id','sidebars_widgets.title','sidebars.name')->orderBy('sidebar_id','desc')->orderBy('order','ASC')->get();
        
        return view('admin.NativeAds.create')->withWidgets($widgets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(! UPerm::ControlNativeAds() ){ return UPerm::Block(); }


       
        $request->validate([
            'title' => 'required',
            'pid' => 'required',
            'places' => 'required',
        ]);
        
        $output = [];
        foreach( $request->places as $place ){
            $output[] = [
                'title' => $request->title,
                'widget_id' => $place['widget_id'],
                'ord'   => $place['ord'],
                'pid'   => $request->pid,
                'status' => $request->status
            ];
        }

        abort_if(!NativeAds::insert($output), 422);
        $exitCode = \Artisan::call('cache:clear');
        
        return redirect('admin/nativeAds');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(! UPerm::ControlNativeAds() ){ return UPerm::Block(); }
        $Ad = NativeAds::where('id', $id)->first();
        if( !$Ad ) return abort(404);
        $places = NativeAds::where('pid', $Ad->pid )->select('widget_id','ord')->orderBy('id','desc')->get();
        

        $widgets = DB::table('sidebars_widgets')->join('sidebars','sidebars.id','=','sidebars_widgets.sidebar_id')->select('sidebars_widgets.id','sidebars_widgets.title','sidebars.name')->orderBy('sidebar_id','desc')->orderBy('order','ASC')->get();
        
        return view('admin.NativeAds.edit')->withWidgets($widgets)->withAd($Ad)->withPlaces($places);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(! UPerm::ControlNativeAds() ){ return UPerm::Block(); }

        $request->validate([
            'title' => 'required',
            'pid' => 'required',
            'places' => 'required',
        ]);

        $output = [];
        foreach( $request->places as $place ){
            $output[] = [
                'title' => $request->title,
                'widget_id' => $place['widget_id'],
                'ord'   => $place['ord'],
                'pid'   => $request->pid,
                'status'=> $request->status
            ];
        }
        
        $delete = NativeAds::where('pid', $request->pid )->delete();
        NativeAds::insert($output);

        $exitCode = \Artisan::call('cache:clear');
        return redirect('admin/nativeAds');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(! UPerm::ControlNativeAds() ){ return UPerm::Block(); }
        $Ad = NativeAds::where('id', $id)->first();

        $delete = NativeAds::where('pid', $Ad->pid )->delete();

        return redirect('admin/nativeAds');
    }

    public function get(){
            return Category::select('id','name')->get(); 
    }
}