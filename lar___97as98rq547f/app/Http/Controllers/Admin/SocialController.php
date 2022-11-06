<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Setting;
use UPerm;


class SocialController extends Controller
{
    public function index(){

$socials = Setting('social_links');
$socials = json_decode($socials);


        if(! UPerm::ControlSettings() ){ return UPerm::Block();  }

        return view('admin.settings.social', compact('socials'));
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){
        if(! UPerm::ControlSettings() ){ return UPerm::Block();  }

        $body = $request->except(['_token','_method']);
        
        $msg = new MessageBag();
        if(count($body)){

            Setting::set( 'social_links', json_encode($body) );
            Setting::save();
            return back()->with('changes', 'تم حفظ التغيرات بنجاح');
        }else{

            $msg->add('columns', 'لم يتم تغيير اي شئ ');
            return back()->withErrors($msg->all());
        }
    }
}
