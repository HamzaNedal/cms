<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;

class CreateCommentRequest extends FormRequest
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
        return [
            'name'      => 'required',
            'email'     => 'required|email',
            'url'       => 'nullable|url',
            'comment'   => 'required|min:10',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'comment' => Purify::clean($this->comment),
            'name' => Purify::clean($this->name),
            'ip_address' => request()->ip(),
            'user_id'    => auth()->check() ? auth()->id() : null,
        ]);
    }
}
