<?php

namespace App\Services;

use Exception;
use App\DTO\MemberDTO;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Interface\MemberInterface;
use Illuminate\Database\Eloquent\Collection;

class MemberServices implements MemberInterface {

    private array $result = array();

    public function all():Collection
    {
        return Member::all();
    }

    public function edit(string $ID):array
    {
        $member = Member::findOrFail($ID);

        $member->church;

        $this->result['member'] = $member;

        return $this->result;
    }

    public function findMembersByChurchID(string $churchID):array
    {
        $members = Member::findMembersByChurchID($churchID);
        if(!$members) throw new Exception("Membros não encontrados", 404);
        
        $this->result['members'] = $members;
        return $this->result;
    }

    public function create(Request $request):array
    {
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

        $member = Member::create($dto->toArray());

        $this->result['message'] = "Membros criados com sucesso!";
        $this->result['member'] = $member;

        return $this->result;
    }

    public function update(Request $request, string $ID):array
    {
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
        $member = Member::findOrFail($ID);

        $member->delete();

        $this->result['success'] = "Membro excluído com sucesso!";

        return $this->result;
    }
}
