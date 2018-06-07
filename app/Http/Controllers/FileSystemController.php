<?php

namespace App\Http\Controllers;

use App\File;
use App\FileSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = Auth::user()->files()->where('path', '0')->paginate(15);
        return view('admin.file.index', compact('files'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->attachment;
            $filename=Auth::user()->getinfo()->first()->name.date("Y/m/d").$file->getClientOriginalName();
            $res = Storage::disk('qiniu')->put($filename, file_get_contents($file->getRealPath()));
            if ($res){
                $ret=Storage::disk('qiniu')->downloadUrl($filename)->setDownload($filename);
                return $ret->geturl();
            }else{
                abort('500');
            }
        }
        return "";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storefile($id, Request $request)
    {

        $file=File::find($id);
        if ($file) {
            $input['pid']=$id;
            $input['path']=$file->path.'/'.$input['pid'];
        }else{
            $input['pid']=$id;
            $input['path']='0';
        }
        $input['type']='1';
        $wenjian=$request->file;
        $input['name']=$wenjian->getClientOriginalName();
        $res = Storage::disk('qiniu')->put( $input['name'], file_get_contents($wenjian->getRealPath()));
        if ($res)
            $input['url'] = Storage::disk('qiniu')->downloadUrl($input['name'])->setDownload($input['name']);
        else{
            abort('500');
        }
        Auth::user()->files()->create($input);
        if ($id!=0)
            return redirect(url('/filesystem',$id));
        else
            return redirect('/filesystem');

    }

        public function storefolder($id, Request $request)
        {
            $input = $request->only('name');
            $file=File::find($id);
            if ($file) {
               $input['pid']=$id;
                $input['path']=$file->path.'/'.$input['pid'];
            }else{
                $input['pid']=$id;
                $input['path']='0';
            }
            $input['url']='';
            Auth::user()->files()->create($input);
            if ($id!=0)
                return redirect(url('/filesystem',$id));
            else
                return redirect('/filesystem');
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public
        function show($id)
        {
            $files = File::where('pid', $id)->paginate(15);
            $parent=File::find($id)->pid;
            return view('admin.file.index', compact('files', 'id','parent'));

        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public
        function edit($id)
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
        public
        function update(Request $request, $id)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public
        function destroy($id)
        {
            //
        }
    }
