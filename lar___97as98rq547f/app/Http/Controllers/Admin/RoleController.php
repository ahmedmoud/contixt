<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use UPerm;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 

    public function index()
    {
        if(! UPerm::ControlRolesPermissions() ){ return UPerm::Block(); }

        $roles = Role::paginate();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Role $role = null)
    {
        if(! UPerm::ControlRolesPermissions() ){ return UPerm::Block(); }
        return view('admin.roles.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(! UPerm::ControlRolesPermissions() ){ return UPerm::Block(); }

        $request->validate([
            'name' => 'required'
        ]);
        $body = $request->except('_token');
        Role::create($body);

        return redirect('/admin/roles')->with('msg', 'Role Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if(! UPerm::ControlRolesPermissions() ){ return UPerm::Block(); }

        return view('admin.roles.create', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if(! UPerm::ControlRolesPermissions() ){ return UPerm::Block(); }

        $body = array_filter($request->except(['_token', '_method']), 'strlen');
        if($role){
            $role->update($body);

            return redirect('/admin/roles')->with('msg', 'Role Updated Successfully');
        }else{
            return back()->withErrors('Role Isn\'t Exists');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if(! UPerm::ControlRolesPermissions() ){ return UPerm::Block(); }

        if($role){
            $role->delete();
            return back()->with('msg', 'Tag Deleted Successfully');
        }else{
            return back();
        }
    }
}
