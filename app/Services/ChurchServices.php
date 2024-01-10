<?php

namespace App\Services;

use App\DTO\ChurchDTO;
use App\Http\Requests\ChurchRequest;
use App\Models\Church;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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

        if(!$church) return ['error' => 'Instituição não encontrada', 'status' => 404];

        $this->result['church'] = $church;

        return ['success' => $this->result, 'status' => 200];
    }

    public function update(Request $request, string $ID):array
    {
        $validator = Validator::make($request->all(), ChurchRequest::rules());

        if($validator->fails()) return ['error' => $validator->errors()->first(), 'status' => 422];

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

        if(!$church) return['error' => 'Instituição não encontrada', 'status' => 404];

        $church->update($dto->toArray());

        $churchFirst = $church->find($ID);

        $this->result['message'] = 'Instituição atualizada com sucesso!';
        $this->result['church'] = $churchFirst;

        return ['success' => $this->result,'status' => 200];
    }

    public function delete(string $ID):array
    {
        $church = Church::find($ID);

        if(!$church) return ['error' => 'Instituição não encontrada', 'status' => 404];

        $church->delete();

        return ['success' => 'Instituição deletada com sucesso!', 'status' => 200];
    }
}
