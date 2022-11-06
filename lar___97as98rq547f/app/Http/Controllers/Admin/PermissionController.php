<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Role_permission;
use Auth;
use DB;
use UPerm;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Role $role
     * @return View
     */
    public function index(Role $role = null)
    {
        if(! UPerm::ControlRolesPermissions() ){ return UPerm::Block(); }

        if($role){
            $permissions = DB::table('permissions')->orderBy('ord','desc')->leftJoin('role_permission','permission_id','=','permissions.id')->where('role_id', $role->id)->where('status',1)->get();
        }else{
            $permissions = false;
        }

        $roles = Role::where('status',1)->get();
        return view('admin.permissions.index', compact('permissions', 'roles', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Role|null $role
     * @return View
     */
    public function create(Role $role = null)
    { 
        if(! UPerm::ControlRolesPermissions() ){ return UPerm::Block(); }

        $roles = Role::all();
        
        $perms = Permission::orderBy('ord','asc')->select('id','.action','section','description')->get();
        $rperms = DB::table('role_permission')->where('role_id', $role->id)->where('status',1)->pluck('permission_id')->toArray();
$rperms = array_map('intval', $rperms);

        return view('admin.permissions.create', compact('role','roles','perms','rperms','rrperms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Role|null $role
     * @return void
     */
    public function store(Request $request, Role $role = null) 
    {
        if(! UPerm::ControlRolesPermissions() ){ return UPerm::Block(); }

        
        $request->validate([
            'role' => 'nullable|integer|exists:roles,id',
        ]);
     
        // $permission = Permission::firstOrCreate($request->except(['_token', '_method']));
        $role_id = $request->role->id;

        $role = $role->id ?? $request->role;
        
        foreach( $request->except('_token') as $key=>$req ){
            
            if( strpos($key, 'perm__') !== false ){ $perID = str_replace('perm__','', $key);
            
               $rp = Role_permission::firstOrNew(['role_id'=>$request->role->id, 'permission_id'=> $perID]);

               $rp->role_id       = $request->role->id;
               $rp->permission_id = $perID;
         
               $rp->status = ($req == '1')? 1 : 0;
               $rp->save();
            }
        }

        // if( $permission->role->id ){
        //     return back();
        // }else{
            
            return redirect('/admin/permissions/' . $role_id);
        //}

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function edit(Role $role, Permission $permission)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Role $role
     * @param Permission $permission
     * @return void
     */
    public function update(Request $request, Role $role, Permission $permission)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return void
     */
    public function destroy(Role $role, Permission $permission)
    {
        if(! UPerm::ControlRolesPermissions() ){ return UPerm::Block(); }

        $role->withDisabledPermissions()->detach($permission->id);

        return redirect('/admin/permissions/'. $role->id);
    }
}
