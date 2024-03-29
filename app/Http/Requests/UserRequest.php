<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    static function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'church_id' => 'required|int',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'permission' => 'required|string',
        ];
    }
}
