<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Setting;
use UPerm;
use Artisan;

class SettingController extends Controller
{
    public function index(){
        if(! UPerm::ControlSettings() ){ return UPerm::Block();  }
        return view('admin.settings.list');
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){
        if(! UPerm::ControlSettings() ){ return UPerm::Block();  }

        $body = array_filter(array_filter($request->except(['_token','_method']), 'trim'), 'strlen');
        $msg = new MessageBag();
        if(count($body)){
            foreach($body as $key => $val){
                Setting::set($key, $val);
            }
            Setting::save();
            $exitCode = Artisan::call('cache:clear');
            return back()->with('changes', 'تم حفظ التغيرات بنجاح');
        }else{
            $msg->add('columns', 'لم يتم تغيير اي شئ ');
            return back()->withErrors($msg->all());
        }

    }
}
