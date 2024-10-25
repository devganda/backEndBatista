<?php

namespace App\Services;

use Exception;
use App\DTO\MemberDTO;
use App\Models\Member;
use App\DTO\MemberCreateDTO;
use Illuminate\Http\Request;
use App\Interface\MemberInterface;
use App\Mappers\MemberMapper;
use Illuminate\Database\Eloquent\Collection;

class MemberServices implements MemberInterface {

    private array $result = array();

    public function all():Collection
    {
        return Member::all();
    }

    public function edit(string $ID):MemberDTO
    {
        $member = Member::findOrFail($ID); 

        return MemberMapper::toDTO($member);
    }

    public function findMembersByChurchID(string $churchID):Collection  
    {
        $members = Member::findMembersByChurchID($churchID);
        
        if(!$members) throw new Exception("Membros não encontrados", 404);

        return  MemberMapper::toCollection($members);
    }

    public function create(MemberCreateDTO $dto):MemberDTO   
    {   
        try {
             
            $member = Member::create($dto->toArray());

            return MemberMapper::toDTO($member); 

        } catch (\Throwable $th) {

            throw new Exception("Error ao criar o membro. msg: {$th->getMessage()}", 500);
        }
       
    }

    public function update(Request $request, string $ID):array
    {
        $member = Member::findOrFail($ID);

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
        $member = Member::findOrFail($ID);

        $member->delete();

        $this->result['success'] = "Membro excluído com sucesso!";

        return $this->result;
    }
}
