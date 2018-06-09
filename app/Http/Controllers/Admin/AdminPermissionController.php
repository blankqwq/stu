<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminPermissionRequest;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::paginate(15);
        return view('houtai.permission.index', compact('permissions'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminPermissionRequest $request)
    {
        $input = $request->only('name', 'display_name', 'description');
        try {
            $newpermision = new Permission();
            $newpermision->name = $input['name'];
            $newpermision->display_name = $input['display_name'];
            $newpermision->description = $input['description'];
            $newpermision->save();
        } catch (\Exception $exception) {
            abort('403');
        }
        return redirect(url('/admin/permissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission=Permission::find($id);
        return view('houtai.permission.showper',compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminPermissionRequest $request, $id)
    {
        $input = $request->only('name', 'display_name', 'description');
        try {
            $newpermision = Permission::find($id);
            $newpermision->name = $input['name'];
            $newpermision->display_name = $input['display_name'];
            $newpermision->description = $input['description'];
            $newpermision->save();
        } catch (\Exception $exception) {
            abort('403');
        }
        return redirect(url('/admin/permissions'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'ids.*' => 'required|exists:permissions,id',
        ]);
        try{
            $ids=$request->ids;
            foreach ($ids as $id){
                Permission::find($id)->delete();
            }
        }catch (\Exception $exception){
            return redirect(url('/admin/permissions'));
        }

        return redirect(url('/admin/permissions'));
    }

    public function trash(){
        $permissions = Permission::onlyTrashed()->paginate(15);
        return view('houtai.permission.index', compact('permissions'));
    }
}
