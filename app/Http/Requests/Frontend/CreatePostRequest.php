<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;

class CreatePostRequest extends FormRequest
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
            'title'         => 'required|string',
            'description'   => 'required|string|min:50',
            'status'        => 'required|integer',
            'comment_able'  => 'required|integer',
            'category_id'   => 'required|integer',
            'images.*'      => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
            'tags.*'        => 'nullable|integer',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'description' => Purify::clean($this->description),
        ]);
    }
}
