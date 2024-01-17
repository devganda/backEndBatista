<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private array $response = array();

    /**
     * @OA\Post(
     *      path="/api/user/register",
     *      operationId="postUserCreate",
     *      tags={"Users"},
     *      summary="adiciona um usuário",
     *     @OA\RequestBody(
     *           required=true,
     *           description="User object precisa para registrar um usuário",
     *          @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="name", type="string", description="Nome do usuário"),
     *               @OA\Property(property="email", type="string", format="email", description="Email do usuário"),
     *               @OA\Property(property="password", type="string", description="senha do usuário")
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="parametro inválido",
     *          @OA\JsonContent(
     *                type="object",
     *                @OA\Property(property="error", type="string", description="Mensagem de erro"),
     *          )
     *      ),
     *     @OA\Response(
     *           response=500,
     *           description="Error",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(property="error", type="string", description="Mensagem de erro"),
     *           )
     *       ),
     *     @OA\Response(
     *           response=201,
     *           description="model Member",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", description="Mensagem de sucesso")
     *          )
     *       ),
     * )
     */
    public function create(Request $request):JsonResponse
    {
       $validator = Validator::make($request->all(), UserRequest::rules());
        if($validator->fails()) {
            $this->response['error'] =  $validator->errors()->first();
            return response()->json($this->response,Response::HTTP_BAD_REQUEST);
        }


        return response()->json();
    }
}
