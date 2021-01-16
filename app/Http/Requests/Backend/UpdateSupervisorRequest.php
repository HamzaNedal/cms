<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupervisorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->ability('admin', 'update_supervisors');
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
            'username'      => 'required|max:20|unique:users,username,'.$this->supervisor->id,
            'email'         => 'required|email|max:255|unique:users,email,'.$this->supervisor->id,
            'mobile'        => 'required|numeric|unique:users,mobile,'.$this->supervisor->id,
            'status'        => 'required',
            'bio'        => 'nullable',
            'receive_email'        => 'nullable',
            'password'      => 'nullable|min:8',
            'permissions.*' => 'required',
        ];
    }

    protected function prepareForValidation()
    {
        if(!$this->password){
            $this->request->remove('password');
        }else{
            $this->password = bcrypt($this->password);
        }
    }
}
