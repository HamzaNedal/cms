<?php

namespace App\Http\Requests\Backend;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->ability('admin', 'create_users');
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
            'username'      => 'required|max:20|unique:users',
            'email'         => 'required|email|max:255|unique:users',
            'mobile'        => 'required|numeric|unique:users',
            'status'        => 'required',
            'password'      => 'required|min:8',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'password' => bcrypt($this->password),
            'email_verified_at' => Carbon::now(),
            'bio' => $this->bio,
            'receive_email' => $this->receive_email,
        ]);
    }
}
