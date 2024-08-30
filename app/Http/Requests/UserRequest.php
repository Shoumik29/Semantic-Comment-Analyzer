<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'userID' => 'required',
            'userName' => 'required',
            'userComment' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'userID.required' => 'User ID is required',
            'userName.required' => 'Username cannot be empty',
            'userComment.required' => 'Please leave a comment'
        ];
    }
}
