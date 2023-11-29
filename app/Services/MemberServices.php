<?php 

namespace App\Services;

use App\DTO\MemberDTO;
use App\Http\Requests\MemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;
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

    public function create(Request $request):array
    {   
        $validator = Validator::make($request->all(), MemberRequest::rulesCreate());

        if($validator->fails()) return['error' => $validator->errors()->first(), 'status' => 422];

        $dto = new MemberDTO(
            ...$request->only([
                'church_id',
                'name',
                'email',
                'age',
                'date_admission_church',
                'phone',
                'UF',
                'address'
            ])
        );
        
        $member = new Member($dto->toArray());
        $member->save();

        $memberFirst = $member->find($member->id);
        $this->result['message'] = "Membros criados com sucesso!";
        $this->result['member'] = $memberFirst;

        return ['success' => $this->result, 'status' => 201];
    }

    public function update(Request $request, string $ID):array
    {
        if(empty($ID)) return [
            'error'=> 'Id vazio!', 
            'status' => 404
        ]; 
        
        $validator = Validator::make(
            $request->all(), 
            MemberRequest::rules()
        );

        if($validator->fails()) return [
            'error' => $validator->errors()->first(), 
            'status' => 422
        ];

        $member = Member::find($ID);

        if(!$member) return [
            'error' => 'Membro não encontrado!', 
            'status' => 404
        ];

        $dto = new MemberDTO(
            ...$request->only([
                'church_id',
                'name',
                'email',
                'age',
                'date_admission_church',
                'phone',
                'UF',
                'address'
            ])
        );

        $member->update($dto->toArray());

        $memberFirst = $member->find($ID);
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