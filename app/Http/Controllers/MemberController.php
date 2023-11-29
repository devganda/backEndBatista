<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\MemberServices;

class MemberController extends Controller
{
    private $result = array();
    public function __construct(
        private MemberServices $memberServices
    ){}
    
    public function index() 
    {
        return response()->json(
            ['members' => $this->memberServices->all()], 
            200
        );
    }

    public function edit(string $ID)
    {      

        if(empty($ID)) {
            $this->result['error'] = "id vazio";
            return response()->json(
                $this->result,
                422
            );
        }

        $this->result = $this->memberServices->edit($ID);

        if(isset($this->result['errorFind'])) return response()->json(
            $this->result, 
            404
        );

        return response()->json($this->result);
    }

    public function create(Request $request)
    {
        $this->result = $this->memberServices->create(
            $request
        );

        if(isset($this->result['errorValidator'])) return response()->json(
            $this->result, 
            422
        ); 

        return response()->json($this->result, 201);
    }

    public function update(Request $request, string $ID)
    {   

        if(empty($ID)) return response()->json(
            ['error'=> 'Id vazio!'],
            404
        ); 

        $this->result = $this->memberServices->update(
            $request, 
            $ID
        );

        if(isset($this->result['errorValidator'])) return response()->json(
            $this->result, 
            422
        );

        if(isset($this->result['errorFind'])) return response()->json(
            $this->result, 
            404
        );

        return response()->json($this->result);
    }

    public function delete(Request $request, string $ID)
    {
        if(empty($ID)) return response()->json(
            ['error'=> 'Id vazio!'],
            404
        ); 

        $this->result = $this->memberServices->delete(
            $ID
        );

        if(isset($this->result['error'])) return response()->json(
            $this->result, 
            404
        );

        return response()->json($this->result); 
    }
}
