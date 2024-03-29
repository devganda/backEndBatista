<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\AuthServices;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected array $response = [];

    public function __construct(
        protected readonly AuthServices $authServices
    ){}

    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="postUserLogin",
     *      tags={"Auth"},
     *      summary="faz o login",
     *     @OA\RequestBody(
     *           required=true,
     *           description="User object precisa para fazer o login",
     *          @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="email", type="string", format="email", description="Email do usuário", default="daniloganda95@gmail.com"),
     *               @OA\Property(property="password", type="string", description="senha do usuário", default="Danilo123")
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
    public function login(AuthRequest $request):JsonResponse
    {
        $this->response = $this->authServices->login($request);

        if(isset($this->response['error'])) return response()->json($this->response, Response::HTTP_UNAUTHORIZED);

        return response()->json($this->response, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/logout",
     *      operationId="getUserLogout",
     *      tags={"Auth"},
     *      summary="faz o logout",
     *      security={{"bearer": {}}},
     *     @OA\Response(
     *           response=200,
     *           description="model Member",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", description="sucesso"),
     *          )
     *       ),
     * )
     */
    public function logout():JsonResponse
    {
        $this->response = $this->authServices->logout();

        return response()->json($this->response, Response::HTTP_OK);
    }
}
