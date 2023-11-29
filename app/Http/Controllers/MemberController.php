<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\MemberServices;

class MemberController extends Controller
{
    private $result = array();
    private MemberServices $memberServices;
    public function __construct(){

        $this->memberServices = new MemberServices();
    }
    
    public function index():object 
    {
        return response()->json(
            ['members' => $this->memberServices->all()], 
            200
        );
    }

    public function edit(string $ID):object
    {
        $result = $this->memberServices->edit($ID);

        if(isset($result['error'])) return response()->json(
            array('error' => $result['error']), 
            $result['status']
        );

        return response()->json(
            $result['success'], 
            $result['status']
        );
    }

    public function create(Request $request):object
    {
        $result = $this->memberServices->create(
            $request
        );

        if(isset($result['error'])) return response()->json(
            ['error' => $result['error']], 
            $result['status']
        ); 

        return response()->json(
            $result['success'], 
            $result['status']
        );
    }

    public function update(Request $request, string $ID):object
    {   
        $result = $this->memberServices->update(
            $request, 
            $ID
        );

        if(isset($result['error'])) return response()->json(
            ['error' => $result['error']], 
            $result['status']
        );

        return response()->json(
            $result['success'], 
            $result['status']
        );
    }

    public function delete(Request $request, string $ID):object
    {
        $result = $this->memberServices->delete(
            $ID
        );

        if(isset($result['error'])) return response()->json(
            ['error' => $result['error']], 
            $result['status']
        ); 

        return response()->json(
            [$result['success']], 
            $result['status']
        ); 
    }
}
