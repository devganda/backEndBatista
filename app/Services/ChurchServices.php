<?php

namespace App\Services;

use App\DTO\ChurchDTO;
use App\Models\Church;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ChurchServices{

    private $result = array();

    public function all():Collection
    {
       return Church::all();
    }

    public function create(Request $request):array
    {
        $dto = new ChurchDTO(
            ...$request->only([
                'name',
                'email',
                'address',
                'cnpj',
                'UF',
                'date_inauguration'
            ])
        );

        $church = new Church($dto->toArray());
        $church->save();
        $churchFirst = $church->find($church->id);
        $this->result['message'] = "Instituição criada com sucesso!";
        $this->result['church'] = $churchFirst;

        return $this->result;
    }

    public function find(string $ID):array
    {
        $church = Church::find($ID);

        if(!$church) return ['error' => 'Instituição não encontrada'];

        $this->result['church'] = $church;

        return $this->result;
    }

    public function update(Request $request, string $ID):array
    {

        $dto = new ChurchDTO(
            ...$request->only([
                'name',
                'email',
                'address',
                'cnpj',
                'UF',
                'date_inauguration'
            ])
        );

        $church = Church::find($ID);

        if(!$church) return ['error' => 'Instituição não encontrada'];

        $church->update($dto->toArray());

        $churchFirst = $church->find($ID);

        $this->result['message'] = 'Instituição atualizada com sucesso!';
        $this->result['church'] = $churchFirst;

        return $this->result;
    }

    public function delete(string $ID):array
    {
        $church = Church::find($ID);

        if(!$church) return ['error' => 'Instituição não encontrada'];

        $church->delete();

        return ['message' => 'Instituição deletada com sucesso!'];
    }
}
