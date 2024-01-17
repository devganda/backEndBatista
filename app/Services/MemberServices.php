<?php

namespace App\Services;

use App\DTO\MemberDTO;
use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class MemberServices {

    private array $result = array();

    public function all():Collection
    {
        return Member::all();
    }

    public function edit(string $ID):array
    {
        $member = Member::find($ID);

        if(!$member){
            $this->result['error'] = "Membro não econtrado!";
            return $this->result;
        }

        $member->church;

        $this->result['member'] = $member;

        return $this->result;
    }

    public function findMembersByChurchID(string $churchID):array
    {
        $membersModel = new Member();
        $members = $membersModel->findMembersByChurchID($churchID);
        if($members->isEmpty()) return ['error' => 'Os membros não foram encontrados!'];
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

        $member = new Member($dto->toArray());
        $member->save();

        $this->result['message'] = "Membros criados com sucesso!";
        $this->result['member'] = $member->find($member->id);

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
        $this->result['error'] = "O Membro não foi encontrado!";

        $member = Member::find($ID);

        if(!$member) return $this->result;

        $member->delete();

        $this->result['success'] = "Membro excluído com sucesso!";

        return $this->result;
    }
}
