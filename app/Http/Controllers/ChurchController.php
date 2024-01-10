<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChurchRequest;
use App\Services\ChurchServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class ChurchController extends Controller
{
    private ChurchServices $churchServices;

    public function __construct()
    {
        $this->churchServices = new ChurchServices();
    }

    /**
     * @OA\Get(
     *      path="/api/church",
     *      operationId="getChurchList",
     *      tags={"Church"},
     *      summary="pega a lista de igrejas",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de Igrejas"
     *      ),
     * )
     */
    public function index():JsonResponse
    {
        $churches = $this->churchServices->all();

        return response()->json(['success' => $churches, 'status' => ResponseAlias::HTTP_OK]);
    }

     public function create(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), ChurchRequest::rules());

        if($validator->fails()) return response()->json(['error' => $validator->errors()->first(), 'status' => 422]);

        $result = $this->churchServices->create($request);

        if(empty($result)) return response()->json(['error' => 'Error na inserção', 'status' => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR]);

        return response()->json(['success' => $result, 'status' => ResponseAlias::HTTP_CREATED]);
    }

    public function edit(string $ID):object
    {
        $result = $this->churchServices->find(
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

    public function update(Request $request, string $ID):object
    {
        $result = $this->churchServices->update(
            $request,
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

    public function delete(string $ID):object
    {
        $result = $this->churchServices->delete(
            $ID
        );

        if(isset($result['error'])) return response()->json(
            ['error' => $result['error']],
            $result['status']
        );

        return response()->json(
            ['success' => $result['success']],
            $result['status']
        );
    }
}
