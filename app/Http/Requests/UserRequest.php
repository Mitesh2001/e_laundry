<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $userId = auth()->id();
        return [
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'email' => ['nullable', 'email', "unique:users,email,$userId,id"],
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'gender' => 'nullable',
            'alternative_phone' => 'nullable',
        ];
    }
}
