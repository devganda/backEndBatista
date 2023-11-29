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
        $member = Member::find($ID);

        if(!$member){
            $this->result['errorFind'] = "Membro não econtrado!"; 
            return $this->result;
        }
    
        $member->church;

        $this->result['member'] = $member;

        return $this->result;
    }

    public function create(Request $request):array
    {   
        $validator = Validator::make(
            $request->all(), 
            MemberRequest::rulesCreate()
        );

        if($validator->fails()) {

            $this->result['errorValidator'] = $validator->errors()->first();
            return $this->result;
        }

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

        $this->result['message'] = "Membros criados com sucesso!";
        $this->result['member'] = $member->find($member->id);

        return $this->result;
    }

    public function update(Request $request, string $ID):array
    {
        $validator = Validator::make(
            $request->all(), 
            MemberRequest::rules()
        );

        if($validator->fails()){

            $this->result['errorValidator'] = $validator->errors()->first();

            return $this->result;
        } 

        $member = Member::find($ID);

        if(!$member){
            $this->result['errorFind'] = "O Membro não foi encontrado!";

            return $this->result;
        } 

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

        $this->result['message'] = "Dados alterados com sucesso!";
        $this->result['member'] = $member->find($ID);

        return $this->result;
    } 

    public function delete(string $ID):array
    {   
        $this->result['error'] = "O Membro não foi encontrado!";

        $member = Member::find($ID);

        if(!$member) return $this->result;
        
        $member->delete();
        
        $this->result['success'] = "Membro excluído com sucesso!";
        
        return $this->result;
    }
}