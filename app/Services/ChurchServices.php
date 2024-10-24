<?php

namespace App\Services;

use Exception;
use App\Models\Church;
use App\DTO\ChurchCreateDTO;
use App\DTO\ChurchDTO;
use App\DTO\SuccessDTO;
use App\Interface\ChurchInterface;
use App\Mappers\ChurchMapper;
use App\Mappers\SuccessMapper;
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

    public function update(ChurchCreateDTO $dto, string $ID):ChurchDTO
    {
        $church = Church::findOrFail($ID);

        $church->update($dto->toArray());

        return ChurchMapper::toDTO($church);
    }

    public function delete(string $ID):SuccessDTO
    {
        $church = Church::findOrFail($ID);

        $church->delete();

        return SuccessMapper::toDTO('Instituição deletada com sucesso!');
    }
}
