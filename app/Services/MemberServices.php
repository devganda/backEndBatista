<?php 

namespace App\Services;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;

class MemberServices {

    private $result = array();

    public function all():object 
    {   
        return Member::all();
    }

    public function edit(string $ID):array
    {
        if(empty($ID)) return ['error' => 'id vazio', 'status' => 422];

        $member = Member::find($ID);

        if(!$member) return ['error' => 'Membro não econtrado!', 'status' => 404];
    
        $member->church;

        $this->result['member'] = $member;

        return ['success' => $this->result, 'status' => 200];
    }

    public function create(array $data):array
    {   
        $validator = Validator::make($data, MemberRequest::rules());

        if($validator->fails()) return['error' => $validator->errors()->first(), 'status' => 422];
        
        $member = new Member();
        
        $member->church_id = $data['church_id'];
        $member->name = $data['name'];
        $member->email = $data['email'];
        $member->age = $data['age'];
        $member->date_admission_church = $data['date_admission_church'];
        $member->phone = $data['phone'];
        $member->UF = $data['UF'];
        $member->address = $data['address'];
        $member->save();

        $memberFirst = $member->find($member->id);
        $this->result['message'] = "Membros criados com sucesso!";
        $this->result['member'] = $memberFirst;

        return ['success' => $this->result, 'status' => 201];
    }

    public function update(array $data, string $ID):array
    {
        if(empty($ID)) return ['error'=> 'Id vazio!', 'status' => 404];
        
        $validator = Validator::make($data, MemberRequest::rules());

        if($validator->fails()) return ['error' => $validator->errors()->first(), 'status' => 422];

        $member = Member::find($ID);

        if(!$member) return ['error' => 'Membro não encontrado!', 'status' => 404];

        $member->name = $data['name'];
        $member->email = $data['email'];
        $member->age = $data['age'];
        $member->date_admission_church = $data['date_admission_church'];
        $member->phone = $data['phone'];
        $member->UF = $data['UF'];
        $member->address = $data['address'];

        $member->save();

        $memberFirst = Member::find($ID);
        $this->result['message'] = "Dados alterados com sucesso!";
        $this->result['member'] = $memberFirst;

        return ['success' => $this->result, 'status' => 200];
    } 

    public function delete(string $ID):array
    {
        if(empty($ID)) return['error'=> 'Id vazio!', 'status' => 404];

        $member = Member::find($ID);

        if(!$member) return ['error'=> 'Membro não encontrado!', 'status' => 404];
        
        $member->delete();
        
        $this->result['message'] = "Membro excluído com sucesso!";
        
        return ['success' => $this->result,'status' => 200];
    }
}