<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FunctionController extends Controller
{

    public function upload(Request $request)
    {
        $this->validate($request, [
            'myfile' => 'image',
        ]);
        $file = $request->myfile;
        $ret = Storage::disk('public')->putfile('upload/editer', $file);

        $data=[
            "errno" => 0,
            "data" => [
                '/storage/'.$ret
            ]
        ];
        return json_encode($data);

    }
}
