<?php

namespace App\Services;


use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    private array $result = [];
    public function create(Request $request):array
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $email_verified_at = $request->input('email_verified_at');
        $password = $request->input('password');
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $userDTO = new UserDTO(
            $name,
            $email,
            $email_verified_at,
            $hash
        );

        $userModel = new User($userDTO->toArray());
        $userModel->save();

        $this->result['message'] = "Usuário criado com sucesso!";

        return $this->result;
    }
}
