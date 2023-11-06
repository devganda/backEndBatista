<?php 

namespace App\Services;
use App\Http\Requests\ChurchRequest;
use App\Models\Church;
use Illuminate\Support\Facades\Validator;

class ChurchServices{

    private $result = array();

    public function all():array
    {  
        return ['success' => Church::all(), 'status' => 200];
    }

    public function create(array $data):array
    {
        $validator = Validator::make($data,ChurchRequest::rules());

        if($validator->fails())return ['error' => $validator->errors()->first(), 'status' => 422];

        $church = new Church();
        $church->name = $data['name'];
        $church->email = $data['email'];
        $church->address = $data['address'];
        $church->cnpj = $data['cnpj'];
        $church->date_inauguration = $data['date_inauguration'];
        $church->UF = $data['UF'];

        $church->save();
        $id = $church->id;
        $churchFirst = $church->find($id);
        $this->result['message'] = "Instituição criada com sucesso!";
        $this->result['church'] = $churchFirst;

        return ['success' => $this->result, 'status' => 201];
    }

    public function find(string $ID):array
    {
        $church = Church::find($ID);

        if(!$church) return ['error' => 'Instituição não encontrada', 'status' => 404];

        $church->members;

        $this->result['church'] = $church;
    
        return ['success' => $this->result, 'status' => 200];
    }

    public function update(array $data, string $ID):array
    {
        $validator = Validator::make($data, ChurchRequest::rules());

        if($validator->fails()) return ['error' => $validator->errors()->first(), 'status' => 422];

        $church = Church::find($ID);

        if(!$church) return['error' => 'Instituição não encontrada', 'status' => 404];

        $church->update($data);

        $churchFirst = Church::find($ID); 
        
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