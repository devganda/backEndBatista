<?php

namespace App\Services;

use Exception;
use App\Models\Church;
use App\DTO\ChurchCreateDTO;
use App\DTO\ChurchDTO;
use Illuminate\Http\Request;
use App\Interface\ChurchInterface;
use App\Mappers\ChurchMapper;
use Illuminate\Database\Eloquent\Collection;

class ChurchServices implements ChurchInterface
{

    private $result = array();  

    public function all():Collection
    {
       return Church::all();
    }

    public function create(ChurchCreateDTO $dto):ChurchDTO  
    {    
        try {
            $church = Church::create($dto->toArray());

            return ChurchMapper::toDTO($church);

        } catch (\Throwable $th) {

            throw new Exception($th->getMessage(), 500);
        }
        
    }

    public function find(string $ID):ChurchDTO 
    {
        $church = Church::findOrFail($ID);

        return ChurchMapper::toDTO($church);
    }

    public function update(Request $request, string $ID):ChurchDTO
    {

        $dto = new ChurchCreateDTO(
            ...$request->only([
                'name',
                'email',
                'address',
                'cnpj',
                'UF',
                'date_inauguration'
            ])
        );

        $church = Church::findOrFail($ID);

        $church->update($dto->toArray());

       return ChurchMapper::toDTO($church);
    }

    public function delete(string $ID):array
    {
        $church = Church::findOrFail($ID);

        $church->delete();

        return ['message' => 'Instituição deletada com sucesso!'];
    }
}
