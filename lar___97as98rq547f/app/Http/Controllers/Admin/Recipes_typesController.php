<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Response;

use App\Recipes_Types;

class Recipes_typesController extends Controller
{

    private $types = ['cuisine'=>'المطبخ','cookMethod'=>'طريقة الطبخ المستخدمة','normalTypes'=>'نوع الوصفة','cost'=>'التكلفة'];

    public function index($type){

        $paginate = 30;

        if( !array_key_exists($type,$this->types) ) return abort(404); 

        $title = $this->types[$type];

        $data =  Recipes_Types::where('type', $type)->orderBy('id','desc')->paginate($paginate);

        return view('admin.recipes_types.list', compact('data','title','type'));

    }

    public function create($type){
        if( !array_key_exists($type,$this->types) ) return abort(404); 

        $title = $this->types[$type];
        return view('admin.recipes_types.create', compact('type','title') );
    }

    public function store($type, Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        
        

        if( !array_key_exists($type,$this->types) ) return abort(404); 

        $body = ['name'=>$request->name, 'type'=> $type,'order'=>0];
        Recipes_Types::create($body);

        return redirect( '/admin/recipes_types/'.$type );
    }

    public function edit($type,$id){
        $data = Recipes_Types::find($id);
        if( !$data ) return abort(404);

        return view('admin.recipes_types.edit', compact('data','type') );
    }


    public function update($type,$id,Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        if( !array_key_exists($type,$this->types) ) return abort(404); 

        $body = ['name'=>$request->name];
        Recipes_Types::where('id', $id)->where('type', $type)->update($body);

        return redirect( '/admin/recipes_types/'.$type );
        
    }

    public function destroy($type, $id){
        
        $data = Recipes_Types::where('id',$id)->where('type', $type)->first();
        if( !$data || in_array($id, [9,10,11]) ) return abort(404);


        $data->delete();

        return redirect( '/admin/recipes_types/'.$type );

    }

}