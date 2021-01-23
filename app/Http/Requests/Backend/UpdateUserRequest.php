<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->ability('admin', 'update_users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
   
        return [
            'name'          => 'required',
            'username'      => 'required|max:20|unique:users,username,'.$this->user->id,
            'email'         => 'required|email|max:255|unique:users,email,'.$this->user->id,
            'mobile'        => 'required|numeric|unique:users,mobile,'.$this->user->id,
            'status'        => 'required',
            'bio'        => 'nullable',
            'receive_email'        => 'nullable',
            'password'      => 'nullable|min:8',
        ];
    }
    protected function prepareForValidation()
    {
        if(!$this->password){
            $this->request->remove('password');
        }
    }
}
