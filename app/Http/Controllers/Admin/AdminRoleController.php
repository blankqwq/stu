<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminPermissionRequest;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Role::paginate();
        return view('houtai.permission.role',compact('roles'));
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
    public function store(AdminPermissionRequest $request)
    {
        $input=$request->only('name','display_name','description');
        try{
            $newrole=new Role();
            $newrole->name = $input['name'];
            $newrole->display_name = $input['display_name'];
            $newrole->description = $input['description'];
            $newrole->save();
        }catch (\Exception $exception){
            abort('403');
        }
        return redirect(url('/admin/roles'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role=Role::with('perms')->find($id);
        $permissions=Permission::all();
        return view('houtai.permission.showrole',compact('role','permissions'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminPermissionRequest $request, $id)
    {
        $input=$request->only('name','display_name','description');
        try{
            $newrole=Role::find($id);
            $newrole->name = $input['name'];
            $newrole->display_name = $input['display_name'];
            $newrole->description = $input['description'];
            $newrole->save();
            $permissionids=$request->permissions;
            foreach ($permissionids as $permissionid){
                try{
                    $newrole->attachPermission($permissionid);
                }catch (\Exception $exception){

                }
            }


        }catch (\Exception $exception){
            abort('403');
        }
        return redirect(url('/admin/roles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'ids.*' => 'required|exists:roles,id',
        ]);
        $ids=$request->ids;
        foreach ($ids as $id){
            Role::find($id)->delete();
        }
        return redirect(url('/admin/roles'));
    }
}
