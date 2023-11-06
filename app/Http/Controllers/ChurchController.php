<?php

namespace App\Http\Controllers;

use App\Services\ChurchServices;
use Illuminate\Http\Request;


class ChurchController extends Controller
{
    private $result = array();
    private ChurchServices $churchServices;

    public function __construct()
    {
        $this->churchServices = new ChurchServices();
    }

    public function index():object
    {
        $result = $this->churchServices->all(); 
        return response()->json(['churches' => $result['success']], $result['status']);
    }

    public function create(Request $request):object
    {
        $result = $this->churchServices->create($request->all());

        if(isset($result['error'])) return response()->json(['error' =>$result['error']], $result['status']); 

        return response()->json([$result['success']], $result['status']);
    }

    public function edit(string $ID):object
    {
        $result = $this->churchServices->find($ID);

        if(isset($result['error'])) return response()->json(['error' => $result['error']], $result['status']);

        return response()->json([$result['success']], $result['status']);
    }

    public function update(Request $request, string $ID):object
    {   
        $result = $this->churchServices->update($request->all(), $ID);

        if(isset($result['error'])) return response()->json(['error' => $result['error']], $result['status']);

        return response()->json([$result['success']], $result['status']);
    }

    public function delete(string $ID):object
    {
        $result = $this->churchServices->delete($ID);

        if(isset($result['error'])) return response()->json(['error' => $result['error']], $result['status'])->json();

        return response()->json(['success' => $result['success']], $result['status']);
    }
}
