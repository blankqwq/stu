<?php

namespace App\Http\Controllers\Admin;

use App\Classes;
use App\ClassType;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminClassTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classtypes = ClassType::paginate(15);
        return view('houtai.classes.classtype', compact('classtypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category' => 'required|min:2|max:10',
        ]);
        $input = $request->only('category');
        ClassType::create($input);
        return redirect('admin/classtype');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classtype = ClassType::withTrashed()->find($id);
        return view('houtai.classes.xiaotype', compact('classtype'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category' => 'required|min:2|max:10',
        ]);
        $classtype = ClassType::find($id);
        $classtype->update(['category' => $request->input('category')]);
        return redirect('admin/classtype');
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
            'ids.*' => 'required|exists:class_type,id',
        ]);
        $ids = $request->input('ids');
        try {
            foreach ($ids as $id) {
                if (ClassType::find($id)->classes())
                    ClassType::find($id)->classes()->delete();
                ClassType::where('id', $id)->delete();
            }
        } catch (\Exception $exception) {
            abort('404');
        }
        return redirect('admin/classtype');
    }

    /*
     * 获取回收站
     *
     */
    public function trash()
    {
        $classtypes = ClassType::onlyTrashed()->paginate(15);
        return view('houtai.classes.classtype', compact('classtypes'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore(Request $request)
    {
        $this->validate($request, [
            'ids.*' => 'required|',
        ]);
        $ids = $request->input('ids');
        try {
            foreach ($ids as $id) {
//                dd(DB::table('class_t')->where('type_id',$id)->get());
                $classes = DB::table('class_t')->where('type_id', $id)->get();
                foreach ($classes as $classe) {
                    Classes::onlyTrashed()->where('id', $classe->class_id)->restore();
                    Role::where('name', 'class' . $classe->class_id)->first()->restore();
                }

            }
            ClassType::where('id', $id)->restore();
        } catch (\Exception $exception) {
            abort('404');
        }

        return redirect('admin/classtype');

    }
}