<?php

namespace App\Services;


use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    private array $result = [];

    public function index():array
    {
        $this->result['users'] = User::all();
        return $this->result;
    }

    public function create(Request $request):array
    {
        $permission = $request->input('permission');
        $userModel = $this->getUserModel($request);
        $userModel->save();
        $userModel->assignPermission($permission);

        $this->result['message'] = "Usuário criado com sucesso!";

        return $this->result;
    }

    public function edit(string $id):array
    {
        $user = User::find($id);
        $church = $user->church;
        $this->result['user'] = $user;

        return $this->result;
    }

    public function update(Request $request, string $id):array
    {
        $user = User::find($id);

        if(!$user){
           $this->result['error'] = 'Usuário não encontrado!';
           return $this->result;
        }

        $userModel = $this->getUserModel($request);
        $userModel->update();

        $this->result['message'] = "Usuário editado com sucesso!";
        $this->result['user'] = $userModel->find($id);

        return $this->result;
    }

    public function delete(string $id):array
    {
        $user = User::find($id);

        if(!$user){
            $this->result['error'] = "Usuário não encontrado!";
            return $this->result;
        }

        $this->result['message'] = "Usuário excluído com sucesso!";
        return $this->result;
    }

    public function getUserModel(Request $request): User
    {
        $name = $request->input('name');
        $church_id = $request->input('church_id');
        $email = $request->input('email');
        $password = $request->input('password');
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $userDTO = new UserDTO(
            $name,
            $church_id,
            $email,
            $hash
        );

        return new User($userDTO->toArray());
    }
}
