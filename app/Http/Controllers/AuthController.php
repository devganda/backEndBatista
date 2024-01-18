<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\AuthServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected array $response = [];

    public function __construct(
        protected readonly AuthServices $authServices
    ){}

    //1|Oa8FBLB72Uq10dJsJdgZwDIKdaFF0GR4Rm3tIlWf88b9b679

    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="postUserLogin",
     *      tags={"Users"},
     *      summary="faz o login",
     *     @OA\RequestBody(
     *           required=true,
     *           description="User object precisa para fazer o login",
     *          @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="email", type="string", format="email", description="Email do usuário"),
     *               @OA\Property(property="password", type="string", description="senha do usuário")
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="parametro inválido",
     *          @OA\JsonContent(
     *                type="object",
     *                @OA\Property(property="error", type="string", description="Unauthorized"),
     *          )
     *      ),
     *     @OA\Response(
     *           response=200,
     *           description="model Member",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", description="Authorized"),
     *             @OA\Property(property="token", type="string", description="token de acesso")
     *          )
     *       ),
     * )
     */
    public function login(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), AuthRequest::rules());
        if($validator->fails()){
            $this->response['error'] = $validator->errors()->first();
            return response()->json($this->response, Response::HTTP_BAD_REQUEST);
        }

        $this->response = $this->authServices->login($request);

        if(isset($this->response['error'])) return response()->json($this->response, Response::HTTP_UNAUTHORIZED);

        return response()->json($this->response, Response::HTTP_OK);
    }
}
