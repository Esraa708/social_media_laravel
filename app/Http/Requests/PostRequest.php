<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
    //  exists:App\User,id'
    public function rules()
    {
        return [
            'title' => 'required  |max:255',
            'content' => 'required',
            'images.*' =>  'image|file|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Post should have a title',
            'content.required' => 'Post content is required',
            'images.image' => 'you should upload an image',
            'images.mimes' => 'image should be from the specified extensions jpeg,png,jpg,gif',

        ];
    }
}
