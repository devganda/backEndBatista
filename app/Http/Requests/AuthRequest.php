<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    static function rules(): array
    {
        return [
            'email' =>'required|string|email',
            'password' => 'required|string'
        ];
    }
}
