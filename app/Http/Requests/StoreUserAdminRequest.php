<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->ability('admin,owner','');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|min:2|max:5',
            'avatar'=>'required|image',
            'password'=>'required|min:6|max:20',
            'permissions.*'=>'exists:permissions,id',
            'roles.*'=>'exists:permissions,id',
            'sex'=>'required|min:1|max:1'
        ];
    }
}
