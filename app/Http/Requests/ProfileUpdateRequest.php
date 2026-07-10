<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'. Auth::id(),
            'current_password'=>'nullable|required_with:newPassword|current_password',
            'newPassword'=>'nullable|required_with:current_password|confirmed|min:8',
            'image'=>'nullable|image|mimes:png,jpg,jpeg',
        ];
    }
}
