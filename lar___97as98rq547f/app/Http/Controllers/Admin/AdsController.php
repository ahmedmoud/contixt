<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Setting;
use UPerm;
use Mobile;

class AdsController extends Controller
{
 

    public function ManageAds(){
        if( !UPerm::HasPerm('manage','ads') ){ return 'Your are not allowed to be here'; }
        $data = [];
        foreach( ['Home','Post','Category'] as $page ){
            foreach( ['Desktop','Mobile'] as $device ){
                $data[$page][$device] = $this->GetAds($page, $device, true);
            }
        }
        return view('admin.ads.manage')->withData($data);
    }

    public function getCode($desktopID, $mobileID){

        $id = Mobile::isMobile() ? $mobileID : $desktopID;
        $ad = \Cache::remember('ad_'.$id.$desktopID.'_'.$mobileID.'__'.\APP::getLocale(), 20*60, function() use ($desktopID, $mobileID) {
                    $id = Mobile::isMobile() ? $mobileID : $desktopID;

            $ad = \DB::table('ads')->where('id', $id)->where('status', 1)->select('code')->first();
            return $ad ? $ad->code : '';
        });

        return $ad;
    }

    public function GetAds($page, $device, $type=false){
        if( !UPerm::HasPerm('manage','ads') ){ return 'Your are not allowed to be here'; }

        $ads = \DB::table('ads')->where(['page'=>$page, 'device'=> $device])->orderBy('id','ASC')->get();
        $data = Collect();
        $data->page = $page;
        $data->device = $device;
        $data->ads = $ads;

        return $type ? $data : view('admin.ads.home', compact('ads','data') );
    }

    public function putAds($page, $device, Request $request){
        if( !UPerm::HasPerm('manage','ads') ){ return 'Your are not allowed to be here'; }

        foreach( $request->except('_token') as $key => $ad ){
            $status = isset($ad['status']) ? 1 : 0;
            $update = \DB::table('ads')->where([
                'page' => $page,
                'device' => $device,
                'area'  => $key
            ])->update([
                'code' => $ad['code'],
                'status' => $status
            ]);
        }
        return redirect( url("/admin/manage-ads/?page=$page&device=$device") );
    }


    public function PostHomeDesktop(){
if( !UPerm::HasPerm('manage','ads') ){ return 'Your are not allowed to be here'; }
        return view('admin.ads.home', compact('') );
    }


    public function index(){
        if( !UPerm::HasPerm('manage','ads') ){ return 'Your are not allowed to be here'; }
        if(! UPerm::ControlAds() ){ return UPerm::Block();  }

        return view('admin.settings.ads');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){
        if( !UPerm::HasPerm('manage','ads') ){ return 'Your are not allowed to be here'; }

        if(! UPerm::ControlAds() ){ return UPerm::Block();  }

        $body = array_filter(array_filter($request->except(['_token','_method']), 'trim'), 'strlen');
        $msg = new MessageBag();
        if(count($body)){

            foreach($body as $key => $val){
                Setting::set($key, $val);
            }

            Setting::save();
            return back()->with('changes', 'تم حفظ التغيرات بنجاح');
        }else{

            $msg->add('columns', 'لم يتم تغيير اي شئ ');
            return back()->withErrors($msg->all());
        }
    }
}