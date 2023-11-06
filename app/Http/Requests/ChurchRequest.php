<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChurchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    
     static function rules(): array
    {
        return [
            'name' =>'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'cnpj' => 'required:string',
            'UF' => 'required|string|max:3',
            'date_inauguration' =>'required|date'
        ];
    }
}
