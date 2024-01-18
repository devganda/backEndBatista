<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthServices
{
    protected array $response = [];
    public function login(Request $request):array
    {
        if(Auth::attempt($request->only('email', 'password'))){
            $this->response['token'] = $request->user()->createToken('token')->plainTextToken;
            return $this->response;
        }

        $this->response['error'] = 'Unauthorized';
        return $this->response;
    }
}
