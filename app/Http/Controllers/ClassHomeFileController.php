<?php

namespace App\Http\Controllers;

use App\Classes;
use App\File;
use App\Http\Requests\ClassFileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClassHomeFileController extends Controller
{
    public function check(Classes $classes){
        if (!Auth::user()->classes()->wherePivot('class_id',$classes->id)->count()>0)
            abort('403');
    }
    public function index($id)
    {
        $classe=Classes::with('boss','types')->withCount('messages')->find($id);
        $this->check($classe);
        if (!$classe)
            abort('404');
        $homecount=Classes::find($id)->homeworks()->count();
        $gongaocount=Classes::find($id)->messages()->where('type_id','1')->count();
        $xuqiucount=Classes::find($id)->messages()->where('type_id','2')->count();
        $files = Classes::find($id)->files()->where('pid', '0')->paginate(15);
        return view('admin.class.home.file', compact('files','classe','homecount','xuqiucount','gongaocount'));
    }

    public function storefolder($id,$file,ClassFileRequest $request){
        $fileid=$file;
        $input = $request->only('name');
        $classfile=Classes::find($id)->files()->find($fileid);
        if ($classfile) {
            $input['pid']=$fileid;
            $input['path']=$classfile->path.'/'.$input['pid'];
        }else{
            $input['pid']=$fileid;
            $input['path']='0';
        }
        $input['url']='';
        Classes::find($id)->files()->create($input);
        if ($fileid!=0)
            return redirect(url('/classhome/'.$id.'/file',$fileid));
        else
            return redirect(url('/classhome/'.$id.'/file.html'));
    }

    public function storefile($id,$file,ClassFileRequest $request){
        $fileid=$file;
        $classfile=Classes::find($id)->files()->find($fileid);
        if ($file) {
            $input['pid']=$fileid;
            $input['path']=$classfile->path.'/'.$input['pid'];
        }else{
            $input['pid']=$fileid;
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
        Classes::find($id)->files()->create($input);
        if ($fileid!=0)
            return redirect(url('/classhome/'.$id.'/file',$fileid));
        else
            return redirect(url('/classhome/'.$id.'/file.html'));
    }

    public function show($id,$file){
        $fileid=$file;
        $classe=Classes::with('boss','types')->withCount('messages')->find($id);
        $this->check($classe);
        if (!$classe)
            abort('404');
        $homecount=Classes::find($id)->homeworks()->count();
        $gongaocount=Classes::find($id)->messages()->where('type_id','1')->count();
        $xuqiucount=Classes::find($id)->messages()->where('type_id','2')->count();
        $files=Classes::find($id)->files()->where('pid', $file)->paginate(15);
        $parent=File::find($file)->pid;
        return view('admin.class.home.file', compact('files', 'fileid','parent','classe','homecount','xuqiucount','gongaocount'));
    }

    public function destroy($id,Request $request){
        $this->validate($request, [
            'ids.*' => 'required|exists:files,id',
        ]);
        $ids = $request->input('ids');
        try{
            foreach ($ids as $fid){
                if (Classes::find($id)->files()->find($fid)){
                    Classes::find($id)->files()->find($fid)->delete();
                    File::where('path','like','%'.$fid.'%')->delete();
                }
            }
            return redirect('/classhome/'.$id.'/file.html');
        }catch (\Exception $exception){
            abort('400');
        }
    }
}
