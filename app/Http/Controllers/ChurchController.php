<?php

namespace App\Http\Controllers;

use App\DTO\ChurchCreateDTO;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Services\ChurchServices;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ChurchRequest;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class ChurchController extends Controller 
{
    public function __construct(private ChurchServices $churchServices){}

    /**
     * @OA\Get(
     *      path="/api/church",
     *      operationId="getChurchList",
     *      tags={"Church"},
     *      summary="pega a lista de igrejas",
     *      security={{"bearer": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *            type="array",
     *            @OA\Items(
     *              type="object",
     *              @OA\Property(property="id", type="integer", description="ID da igreja"),
     *              @OA\Property(property="name", type="string", description="Nome da igreja"),
     *              @OA\Property(property="email", type="string", description="Email da igreja"),
     *              @OA\Property(property="address", type="string", description="Endereço da igreja"),
     *              @OA\Property(property="cnpj", type="string", description="CNPJ da igreja"),
     *              @OA\Property(property="UF", type="string", description="UF da igreja"),
     *              @OA\Property(property="date_inauguration", type="string", format="date", description="Data de inauguração da igreja"),
     *              @OA\Property(property="created_at", type="string", format="date-time", description="Data e hora de criação"),
     *              @OA\Property(property="updated_at", type="string", format="date-time", description="Data e hora de atualização"),
     *           )
     *         )
     *      ),
     *
     *     @OA\Response(
     *           response=401,
     *           description="token inválido",
     *           @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="error", type="string", description="Unauthorized"),
     *           )
     *       ),
     * )
     */
    public function index():JsonResponse
    {
        $churches = $this->churchServices->all();

        return response()->json($churches,ResponseAlias::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/church/create",
     *      operationId="postChurchCreate",
     *      tags={"Church"},
     *      summary="adiciona uma igreja",
     *     security={{"bearer": {}}},
     *     @OA\RequestBody(
     *           required=true,
     *           description="User object precisa para adicionar uma igreja",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", description="Nome da igreja"),
     *              @OA\Property(property="email", type="string", format="email", description="Email da igreja"),
     *              @OA\Property(property="address", type="string", description="Endereço da igreja"),
     *              @OA\Property(property="cnpj", type="string", description="cnpj da igreja"),
     *              @OA\Property(property="UF", type="string", description="Estado da igreja"),
     *              @OA\Property(property="date_inauguration", type="string", format="date", description="data de inauguração da igreja")
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
     *           description="criado",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", description="Mensagem de sucesso"),
     *              @OA\Property(
     *                  property="church",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", description="ID da igreja"),
     *                  @OA\Property(property="name", type="string", description="Nome da igreja"),
     *                  @OA\Property(property="email", type="string", description="Email da igreja"),
     *                  @OA\Property(property="address", type="string", description="Endereço da igreja"),
     *                  @OA\Property(property="cnpj", type="string", description="CNPJ da igreja"),
     *                  @OA\Property(property="UF", type="string", description="UF da igreja"),
     *                  @OA\Property(property="date_inauguration", type="string", format="date", description="Data de inauguração da igreja"),
     *                  @OA\Property(property="created_at", type="string", format="date-time", description="Data e hora de criação"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", description="Data e hora de atualização"),
     *              )
     *          )
     *       ),
     * )
     */
     public function create(Request $request):JsonResponse
    {
        $validator = Validator::make(
            $request->all(), 
            ChurchRequest::rules()
        );

        if($validator->fails()) return response()->json(['error' => $validator->errors()->first()],ResponseAlias::HTTP_BAD_REQUEST);

         $dto = new ChurchCreateDTO( 
            ...$request->only([
                'name',
                'email',
                'address',
                'cnpj',
                'UF',
                'date_inauguration'
            ])
        );
        
        $result = $this->churchServices->create($dto);

        return response()->json($result, ResponseAlias::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/church/edit/{id}",
     *      operationId="getChurchListByID",
     *      tags={"Church"},
     *      summary="pega as info de uma igreja em especifico",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID da igreja",
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *           response=400,
     *           description="parametro inválido",
     *           @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="error", type="string", description="Mensagem de erro"),
     *           )
     *       ),
     *     @OA\Response(
     *            response=500,
     *            description="Error",
     *            @OA\JsonContent(
     *                type="object",
     *                @OA\Property(property="error", type="string", description="Mensagem de erro"),
     *            )
     *        ),
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *            type="object",
     *            @OA\Property(
     *               property="church",
     *               type="object",
     *               @OA\Property(property="id", type="integer", description="ID da igreja"),
     *               @OA\Property(property="name", type="string", description="Nome da igreja"),
     *               @OA\Property(property="email", type="string", description="Email da igreja"),
     *               @OA\Property(property="address", type="string", description="Endereço da igreja"),
     *               @OA\Property(property="cnpj", type="string", description="CNPJ da igreja"),
     *               @OA\Property(property="UF", type="string", description="UF da igreja"),
     *               @OA\Property(property="date_inauguration", type="string", format="date", description="Data de inauguração da igreja"),
     *               @OA\Property(property="created_at", type="string", format="date-time", description="Data e hora de criação"),
     *               @OA\Property(property="updated_at", type="string", format="date-time", description="Data e hora de atualização"),
     *            )
     *         )
     *      ),
     * )
     */
    public function edit(string $ID):JsonResponse
    {
        if (empty($ID)) return response()->json(
            [
                'error' => 'O parâmetro ID está vazio!',
                'status' => ResponseAlias::HTTP_BAD_REQUEST
            ]
        );

        $result = $this->churchServices->find($ID);

        if(isset($result['error'])) return response()->json($result, ResponseAlias::HTTP_NOT_FOUND);

        return response()->json($result, ResponseAlias::HTTP_OK);
    }

    /**
     * @OA\Put(
     *      path="/api/church/update/{id}",
     *      operationId="putChurchUpdate",
     *      tags={"Church"},
     *      summary="atualiza uma igreja",
     *      @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="ID da igreja",
     *           @OA\Schema(type="integer")
     *       ),
     *     @OA\RequestBody(
     *           required=true,
     *           description="atualiza os dados de uma igreja",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", description="Nome da igreja"),
     *              @OA\Property(property="email", type="string", format="email", description="Email da igreja"),
     *              @OA\Property(property="address", type="string", description="Endereço da igreja"),
     *              @OA\Property(property="cnpj", type="string", description="cnpj da igreja"),
     *              @OA\Property(property="UF", type="string", description="Estado da igreja"),
     *              @OA\Property(property="date_inauguration", type="string", format="date", description="data de inauguração da igreja")
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
     *           response=200,
     *           description="Sucesso",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", description="Mensagem de sucesso"),
     *              @OA\Property(
     *                  property="church",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", description="ID da igreja"),
     *                  @OA\Property(property="name", type="string", description="Nome da igreja"),
     *                  @OA\Property(property="email", type="string", description="Email da igreja"),
     *                  @OA\Property(property="address", type="string", description="Endereço da igreja"),
     *                  @OA\Property(property="cnpj", type="string", description="CNPJ da igreja"),
     *                  @OA\Property(property="UF", type="string", description="UF da igreja"),
     *                  @OA\Property(property="date_inauguration", type="string", format="date", description="Data de inauguração da igreja"),
     *                  @OA\Property(property="created_at", type="string", format="date-time", description="Data e hora de criação"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", description="Data e hora de atualização"),
     *              )
     *          )
     *       ),
     * )
     */
    public function update(Request $request, string $ID):JsonResponse
    {
        $validator = Validator::make($request->all(), ChurchRequest::rules());

        if($validator->fails()) return response()->json(
            ['error' => $validator->errors()->first()],
            ResponseAlias::HTTP_BAD_REQUEST
        );

        $result = $this->churchServices->update(
            $request,
            $ID
        );

        if(isset($result['error'])) return response()->json(
            $result,
            ResponseAlias::HTTP_NOT_FOUND
        );

        return response()->json(
           $result,
            ResponseAlias::HTTP_OK
        );
    }

    /**
     * @OA\Delete(
     *      path="/api/church/delete/{id}",
     *      operationId="deleteChurchListByID",
     *      tags={"Church"},
     *      summary="deleta as info de uma igreja em especifico",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID da igreja",
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *           response=400,
     *           description="parametro inválido",
     *           @OA\JsonContent(
     *                 type="object",
     *                 @OA\Property(property="error", type="string", description="Mensagem de erro"),
     *           )
     *       ),
     *     @OA\Response(
     *            response=404,
     *            description="Error",
     *            @OA\JsonContent(
     *                type="object",
     *                @OA\Property(property="error", type="string", description="Mensagem de erro"),
     *            )
     *        ),
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *            type="object",
     *            @OA\Property(
     *               property="message",
     *               type="string",
     *            )
     *         )
     *      ),
     * )
     */
    public function delete(string $ID):JsonResponse
    {
        if (empty($ID)) return response()->json(
            ['error' => 'O parâmetro ID está vazio!'],
            ResponseAlias::HTTP_BAD_REQUEST
        );

        $result = $this->churchServices->delete($ID);

        if(isset($result['error'])) return response()->json(
            $result,
            ResponseAlias::HTTP_NOT_FOUND
        );

        return response()->json(
            $result,
            ResponseAlias::HTTP_OK
        );
    }
}
