<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserRequestUpdate;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private array $response = array();

    public function __construct(
        protected readonly UserService $userService
    ){}

    /**
     * @OA\Get(
     *      path="/api/users",
     *      operationId="getUser",
     *      tags={"Users"},
     *      summary="pega todos os usuários",
     *      security={{"bearer": {}}},
     *     @OA\Response(
     *           response=200,
     *           description="Sucesso",
     *           @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(
     *               type="object",
     *               @OA\Property(property="id", type="integer", description="ID do usuário"),
     *               @OA\Property(property="name", type="string", description="Nome do usuário"),
     *               @OA\Property(property="email", type="string", description="Email do usuário"),
     *               @OA\Property(property="email_verified_at", type="string", description="Email do usuário"),
     *               @OA\Property(property="created_at", type="string", format="date-time", description="Data e hora de criação"),
     *               @OA\Property(property="updated_at", type="string", format="date-time", description="Data e hora de atualização"),
     *            )
     *          )
     *       ),
     *
     *     @OA\Response(
     *            response=401,
     *            description="token inválido",
     *            @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(property="error", type="string", description="Unauthorized"),
     *            )
     *        ),
     * )
     */
    public function index():JsonResponse
    {
        $this->response = $this->userService->index();
        return response()->json($this->response, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/register",
     *      operationId="postUserCreate",
     *      tags={"Users"},
     *      summary="adiciona um usuário",
     *     @OA\RequestBody(
     *           required=true,
     *           description="User object precisa para registrar um usuário",
     *          @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="name", type="string", description="Nome do usuário"),
     *               @OA\Property(property="church_id", type="int", description="id da Igreja"),
     *               @OA\Property(property="email", type="string", format="email", description="Email do usuário"),
     *               @OA\Property(property="password", type="string", description="senha do usuário"),
     *               @OA\Property(property="permission", type="string", description="permissão do usuário")
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
     *           response=201,
     *           description="model Member",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", description="Mensagem de sucesso")
     *          )
     *       ),
     * )
     */
    public function create(UserRequest $request):JsonResponse
    {
        $this->response = $this->userService->create($request);

        if(isset($this->response['error'])) return response()->json($this->response, Response::HTTP_INTERNAL_SERVER_ERROR);

        return response()->json($this->response, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/users/edit/{id}",
     *      operationId="getUserEdit",
     *      tags={"Users"},
     *      summary="pega o usuário pelo id",
     *      security={{"bearer": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="ID do usuário",
     *           @OA\Schema(type="integer")
     *       ),
     *     @OA\Response(
     *           response=200,
     *           description="Sucesso",
     *           @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(
     *               type="object",
     *               @OA\Property(property="id", type="integer", description="ID do usuário"),
     *               @OA\Property(property="name", type="string", description="Nome do usuário"),
     *               @OA\Property(property="email", type="string", description="Email do usuário"),
     *               @OA\Property(property="email_verified_at", type="string", description="Email do usuário"),
     *               @OA\Property(property="created_at", type="string", format="date-time", description="Data e hora de criação"),
     *               @OA\Property(property="updated_at", type="string", format="date-time", description="Data e hora de atualização"),
     *            )
     *          )
     *       ),
     *
     *      @OA\Response(
     *            response=400,
     *            description="parametro inválido",
     *            @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(property="error", type="string", description="Mensagem de erro"),
     *            )
     *        ),
     *
     *      @OA\Response(
     *            response=404,
     *            description="Não encontrado",
     *            @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(property="error", type="string", description="Mensagem de erro"),
     *            )
     *        ),
     *
     *     @OA\Response(
     *            response=401,
     *            description="token inválido",
     *            @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(property="error", type="string", description="Unauthorized"),
     *            )
     *        ),
     * )
     */
    public function edit(string $id):JsonResponse
    {
        $validator = Validator::make(['id'=> $id], IdRequest::rules());

        if($validator->fails()) {
            $this->response['error'] = $validator->errors()->first();
            return response()->json($this->response, Response::HTTP_BAD_REQUEST);
        }

        $this->response = $this->userService->edit($id);

        if(isset($this->response['error'])) return response()->json($this->response, Response::HTTP_NOT_FOUND);

        return response()->json($this->response, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *      path="/api/users/update/{id}",
     *      operationId="putUserUpdate",
     *      tags={"Users"},
     *      summary="atualiza um usuário",
     *     security={{"bearer": {}}},
     *     @OA\Parameter(
     *            name="id",
     *            in="path",
     *            required=true,
     *            description="ID do usuário",
     *            @OA\Schema(type="integer")
     *        ),
     *     @OA\RequestBody(
     *           required=true,
     *           description="User object precisa para registrar um usuário",
     *          @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="name", type="string", description="Nome do usuário"),
     *               @OA\Property(property="church_id", type="int", description="id da Igreja"),
     *               @OA\Property(property="email", type="string", format="email", description="Email do usuário"),
     *               @OA\Property(property="permission", type="string", description="Permissão do usuário")
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
     *           response=200,
     *           description="model Member",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", description="Mensagem de sucesso"),
     *                @OA\Property(property="id", type="int", description'="id do usuário"),
     *                @OA\Property(property="name", type="string", description="Nome do usuário"),
     *                @OA\Property(property="email", type="string", format="email", description="Email do usuário"),
     *                @OA\Property(property="church_id", type="int", description="id da Igreja")
     *          )
     * )
     */
    public function update(UserRequestUpdate $request, string $id):JsonResponse
    {
        $validatorId = Validator::make(['id'=> $id], IdRequest::rules());

        if($validatorId->fails()) {
            $this->response['error'] =  $validatorId->errors()->first();
            return response()->json($this->response,Response::HTTP_BAD_REQUEST);
        }

        $this->response = $this->userService->update($request, $id);

        if(isset($this->response['error'])) return response()->json($this->response, Response::HTTP_NOT_FOUND);

        return response()->json($this->response, Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *      path="/api/users/delete/{id}",
     *      operationId="getUserDelete",
     *      tags={"Users"},
     *      summary="deleta o usuário pelo id",
     *      security={{"bearer": {}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="ID do usuário",
     *           @OA\Schema(type="integer")
     *       ),
     *     @OA\Response(
     *           response=200,
     *           description="Sucesso",
     *           @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", description="Sucesso")
     *          )
     *       ),
     *
     *     @OA\Response(
     *           response=400,
     *           description="parametro inválido",
     *           @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="error", type="string", description="Mensagem de erro"),
     *           )
     *       ),
     *
     *     @OA\Response(
     *           response=404,
     *           description="Não encontrado",
     *           @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="error", type="string", description="Mensagem de erro"),
     *           )
     *       ),
     *
     *     @OA\Response(
     *            response=401,
     *            description="token inválido",
     *            @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(property="error", type="string", description="Unauthorized"),
     *            )
     *        ),
     * )
     */
    public function delete(string $id):JsonResponse
    {
        $validatorId = Validator::make(['id'=> $id], IdRequest::rules());

        if($validatorId->fails()) {
            $this->response['error'] =  $validatorId->errors()->first();
            return response()->json($this->response,Response::HTTP_BAD_REQUEST);
        }

        $this->response = $this->userService->delete($id);

        if(isset($this->response['error'])) return response()->json($this->response, Response::HTTP_NOT_FOUND);

        return response()->json($this->response, Response::HTTP_OK);
    }
}
