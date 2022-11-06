<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use Auth;
use Http;
use UPerm;

class CustomTemplatesController extends Controller
{
    public function BreastCancer(){
        $d = \DB::table('settings')->where('key', 'BreastCancer')->first();
        $value = $d->value;
        $value = json_decode( $value );
        return view('admin.customTemplates.BreastCancer')->withValue( $value );
    }
    public function SaveBreastCancer(Request $request){
        $req = $request->except('_token');
        $req = json_encode( $req );
        $d = \DB::table('settings')->where('key', 'BreastCancer')->update(['value'=>$req]);

        $d = \DB::table('settings')->where('key', 'BreastCancer')->first();
        $value = $d->value;
        $value = json_decode( $value );

        return view('admin.customTemplates.BreastCancer')->withValue( $value );

    }

    public function Autism(){
        $d = \DB::table('settings')->where('key', 'Autism')->first();
        $value = $d->value;
        $value = json_decode( $value );
        return view('admin.customTemplates.Autism')->withValue( $value );
    }
    public function SaveAutism(Request $request){
        $req = $request->except('_token');
        $req = json_encode( $req );
        $d = \DB::table('settings')->where('key', 'Autism')->update(['value'=>$req]);

        $d = \DB::table('settings')->where('key', 'Autism')->first();
        $value = $d->value;
        $value = json_decode( $value );

        return view('admin.customTemplates.Autism')->withValue( $value );

    }
    
}