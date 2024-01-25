<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserRequestUpdate;
use App\Models\User;
use Exception;

class UserService
{
    private array $result = [];

    public function index():array
    {
        $this->result['users'] = User::all();
        return $this->result;
    }

    public function create(UserRequest $request):array
    {
        try{
            $permission = $request->input('permission');
            $userModel = $this->getUserModel($request);
            $userModel->save();
            $userModel->assignPermission($permission);
            $this->result['message'] = "Usuário criado com sucesso!";
            return $this->result;

        }catch (Exception $e){
            $this->result['error'] = "Error ao criar o usuário!";
            return $this->result;
        }
    }

    public function edit(string $id):array
    {
        try{
            $user = User::findOrFail($id);
            $church = $user->church;
            $permissions = $user->permissions;
            $this->result['user'] = $user;
            return $this->result;

        }catch (Exception $e){
            $this->result['error'] = "Error ao buscar o usuário!";
            return $this->result;
        }
    }

    public function update(UserRequestUpdate $request, string $id):array
    {
        try{
            $user = User::findOrFail($id);
            $permission = $request->input('permission');
            $user->name =  $request->input('name');
            $user->church_id =  $request->input('church_id');
            $user->email =  $request->input('email');
            $user->save();
            $user->assignPermission($permission);

            $this->result['message'] = "Usuário editado com sucesso!";
            $this->result['user'] = $user->find($id);
            return $this->result;

        }catch (Exception $e){
            $this->result['error'] = "Error ao atualizar o usuário!";
            return $this->result;
        }
    }

    public function delete(string $id):array
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            $this->result['message'] = "Usuário excluído com sucesso!";
            return $this->result;

        }catch (Exception $e){
            $this->result['error'] = "Usuário não encontrado!";
            return $this->result;
        }
    }

    public function getUserModel($request): User
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
