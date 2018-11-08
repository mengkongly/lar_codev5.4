<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // $email_required =   'required|unique:users,email';
        // if($this->method()=='PATCH'){
        //     $email_required =   'required|unique:users,email,'.$this->get('id');
        // }

        return [
            //
            'name'=>'required|max:50',
            'role_id'=>'required',
            'email'=>'required|unique:users,email',
            // 'email'=>$email_required,
            'password'=>'required|min:6',
            'file'=>'required|max:5120'
        ];
    }

}
