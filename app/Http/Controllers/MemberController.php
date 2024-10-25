<?php

namespace App\Http\Controllers;
use App\DTO\MemberCreateDTO;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Services\MemberServices;
use Illuminate\Http\JsonResponse;
use App\Interface\MemberInterface;
use App\Http\Requests\MemberRequest;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class MemberController extends Controller 
{
    private array $result = array();
    public function __construct(
        private readonly MemberServices $memberServices
    ){}

    /**
     * @OA\Get(
     *      path="/api/members",
     *      operationId="getMembersList",
     *      tags={"Members"},
     *      summary="pega a lista de todos os membros",
     *      @OA\Response(
     *          response=200,
     *          description="Sucesso",
     *          @OA\JsonContent(
     *            type="array",
     *            @OA\Items(
     *              type="object",
     *              @OA\Property(property="id", type="integer", description="ID do membro"),
     *              @OA\Property(property="church_id", type="int", description="ID da igreja"),
     *              @OA\Property(property="name", type="string", description="Nome do membro"),
     *              @OA\Property(property="email", type="string", description="Email do membro"),
     *              @OA\Property(property="age", type="int", description="Idade do membro"),
     *              @OA\Property(property="date_admission_church", type="date", description="data de admissão do membro"),
     *              @OA\Property(property="phone", type="string", description="Númeto celular do membro"),
     *              @OA\Property(property="UF", type="string", format="string", description="Estado do membro"),
     *              @OA\Property(property="address", type="string", format="string", description="Endereço do membro"),
     *              @OA\Property(property="created_at", type="string", format="date-time", description="Data e hora de criação"),
     *              @OA\Property(property="updated_at", type="string", format="date-time", description="Data e hora de atualização"),
     *           )
     *         )
     *      ),
     * )
     */
    public function index():JsonResponse
    {
        $allMembers = $this->memberServices->all();
        return response()->json($allMembers, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *      path="/api/members/edit/{id}",
     *      operationId="getMemberListByID",
     *      tags={"Members"},
     *      summary="pega as info de um membro especifico",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID do membro",
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
     *               property="member",
     *               type="object",
     *               @OA\Property(property="id", type="integer", description="ID do membro"),
     *               @OA\Property(property="church_id", type="int", description="ID da igreja"),
     *               @OA\Property(property="name", type="string", description="Nome do membro"),
     *               @OA\Property(property="email", type="string", description="Email do membro"),
     *               @OA\Property(property="age", type="int", description="Idade do membro"),
     *               @OA\Property(property="date_admission_church", type="date", description="data de admissão do membro"),
     *               @OA\Property(property="phone", type="string", description="Númeto celular do membro"),
     *               @OA\Property(property="UF", type="string", format="string", description="Estado do membro"),
     *               @OA\Property(property="address", type="string", format="string", description="Endereço do membro"),
     *               @OA\Property(property="created_at", type="string", format="date-time", description="Data e hora de criação"),
     *               @OA\Property(property="updated_at", type="string", format="date-time", description="Data e hora de atualização"),
     *               @OA\Property(
     *                property="church",
     *                type="object",
     *                @OA\Property(property="id", type="integer", description="ID da igreja"),
     *                @OA\Property(property="name", type="string", description="Nome da igreja"),
     *                @OA\Property(property="email", type="string", description="Email da igreja"),
     *                @OA\Property(property="address", type="string", description="Endereço da igreja"),
     *                @OA\Property(property="cnpj", type="string", description="CNPJ da igreja"),
     *                @OA\Property(property="UF", type="string", description="UF da igreja"),
     *                @OA\Property(property="date_inauguration", type="string", format="date", description="Data de inauguração da igreja"),
     *                @OA\Property(property="created_at", type="string", format="date-time", description="Data e hora de criação"),
     *                @OA\Property(property="updated_at", type="string", format="date-time", description="Data e hora de atualização"),
     *               )
     *            )
     *         )
     *      ),
     * )
     */
    public function edit(string $ID):JsonResponse
    {
        if(empty($ID)) {
            $this->result['error'] = "Parâmetro inválido";
            return response()->json($this->result, Response::HTTP_BAD_REQUEST);
        }

        $this->result = $this->memberServices->edit($ID);

        if(isset($this->result['error'])) return response()->json($this->result, Response::HTTP_NOT_FOUND);

        return response()->json($this->result, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/members/create",
     *      operationId="postMemberCreate",
     *      tags={"Members"},
     *      summary="adiciona um membro",
     *     @OA\RequestBody(
     *           required=true,
     *           description="User object precisa para adicionar uma igreja",
     *          @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="church_id", type="int", description="ID da igreja"),
     *               @OA\Property(property="name", type="string", description="Nome do membro"),
     *               @OA\Property(property="email", type="string", format="email", description="Email do membro"),
     *               @OA\Property(property="age", type="int", description="Idade do membro"),
     *               @OA\Property(property="date_admission_church", type="date", description="data de admissão do membro"),
     *               @OA\Property(property="phone", type="string", description="Númeto celular do membro"),
     *               @OA\Property(property="UF", type="string", format="string", description="Estado do membro"),
     *               @OA\Property(property="address", type="string", format="string", description="Endereço do membro"),
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
     *             @OA\Property(property="message", type="string", description="Mensagem de sucesso"),
     *             @OA\Property(
     *                property="member",
     *                type="object",
     *                @OA\Property(property="id", type="integer", description="ID do membro"),
     *                @OA\Property(property="church_id", type="int", description="ID da igreja"),
     *                @OA\Property(property="name", type="string", description="Nome do membro"),
     *                @OA\Property(property="email", type="string", description="Email do membro"),
     *                @OA\Property(property="age", type="int", description="Idade do membro"),
     *                @OA\Property(property="date_admission_church", type="date", description="data de admissão do membro"),
     *                @OA\Property(property="phone", type="string", description="Númeto celular do membro"),
     *                @OA\Property(property="UF", type="string", format="string", description="Estado do membro"),
     *                @OA\Property(property="address", type="string", format="string", description="Endereço do membro"),
     *                @OA\Property(property="created_at", type="string", format="date-time", description="Data e hora de criação"),
     *                @OA\Property(property="updated_at", type="string", format="date-time", description="Data e hora de atualização"),
     *             )
     *          )
     *       ),
     * )
     */
    public function create(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), MemberRequest::rulesCreate());

        if($validator->fails()) {
            $this->result['error'] = $validator->errors()->first();
            return response()->json($this->result, Response::HTTP_BAD_REQUEST);
        }

        $dto = new MemberCreateDTO(
            ...$request->only([
                'church_id',
                'name',
                'email',
                'age',
                'date_admission_church',
                'phone',
                'UF',
                'address'
            ]) 
        );

        $this->result = $this->memberServices->create(
            $dto
        );

        return response()->json($this->result, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/members/show/{id}",
     *      operationId="getMemberListByIDChurch",
     *      tags={"Members"},
     *      summary="pega as info de um membro especifico",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID da Igreja",
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
     *             type="object",
     *             @OA\Property(
     *              property="members",
     *              type="array",
     *               @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="ID do membro"),
     *                 @OA\Property(property="church_id", type="int", description="ID da igreja"),
     *                 @OA\Property(property="name", type="string", description="Nome do membro"),
     *                 @OA\Property(property="email", type="string", description="Email do membro"),
     *                 @OA\Property(property="age", type="int", description="Idade do membro"),
     *                 @OA\Property(property="date_admission_church", type="date", description="data de admissão do membro"),
     *                 @OA\Property(property="phone", type="string", description="Númeto celular do membro"),
     *                 @OA\Property(property="UF", type="string", format="string", description="Estado do membro"),
     *                 @OA\Property(property="address", type="string", format="string", description="Endereço do membro"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Data e hora de criação"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Data e hora de atualização"),
     *               )
     *             )
     *          )
     *      ),
     * )
     */
    public function findMembersByChurchID(string $churchID): JsonResponse
    {
        if(empty($churchID)) {
            $this->result['error'] = "Parâmetro inválido";
            return response()->json($this->result, Response::HTTP_BAD_REQUEST);
        }

        $members = $this->memberServices->findMembersByChurchID($churchID);

        if(isset($members['error'])) return response()->json($members, Response::HTTP_NOT_FOUND);

        return response()->json($members, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *      path="/api/members/update/{id}",
     *      operationId="putMemberUpdate",
     *      tags={"Members"},
     *      summary="atualiza um membro",
     *      @OA\Parameter(
     *           name="id",
     *           in="path",
     *           required=true,
     *           description="ID do membro",
     *           @OA\Schema(type="integer")
     *       ),
     *     @OA\RequestBody(
     *           required=true,
     *           description="atualiza os dados de um membro",
     *          @OA\JsonContent(
     *              type="object",
     *                @OA\Property(property="church_id", type="int", description="ID da igreja"),
     *                @OA\Property(property="name", type="string", description="Nome do membro"),
     *                @OA\Property(property="email", type="string", format="email", description="Email do membro"),
     *                @OA\Property(property="age", type="int", description="Idade do membro"),
     *                @OA\Property(property="date_admission_church", type="date", description="data de admissão do membro"),
     *                @OA\Property(property="phone", type="string", description="Númeto celular do membro"),
     *                @OA\Property(property="UF", type="string", format="string", description="Estado do membro"),
     *                @OA\Property(property="address", type="string", format="string", description="Endereço do membro"),
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
     *                  property="member",
     *                  type="object",
     *                 @OA\Property(property="id", type="integer", description="ID do membro"),
     *                 @OA\Property(property="church_id", type="int", description="ID da igreja"),
     *                 @OA\Property(property="name", type="string", description="Nome do membro"),
     *                 @OA\Property(property="email", type="string", description="Email do membro"),
     *                 @OA\Property(property="age", type="int", description="Idade do membro"),
     *                 @OA\Property(property="date_admission_church", type="date", description="data de admissão do membro"),
     *                 @OA\Property(property="phone", type="string", description="Númeto celular do membro"),
     *                 @OA\Property(property="UF", type="string", format="string", description="Estado do membro"),
     *                 @OA\Property(property="address", type="string", format="string", description="Endereço do membro"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Data e hora de criação"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Data e hora de atualização"),
     *              )
     *          )
     *       ),
     * )
     */
    public function update(Request $request, string $ID):JsonResponse
    {
        if(empty($ID)) return response()->json(['error'=> 'Parâmetro inválido!'],Response::HTTP_BAD_REQUEST);

        $validator = Validator::make($request->all(), MemberRequest::rules());

        if($validator->fails()){
            $this->result['error'] = $validator->errors()->first();
            return response()->json($this->result, Response::HTTP_BAD_REQUEST);
        }

        $this->result = $this->memberServices->update(
            $request,
            $ID
        );

        if(isset($this->result['error'])) return response()->json($this->result,Response::HTTP_NOT_FOUND);

        return response()->json($this->result, Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *      path="/api/members/delete/{id}",
     *      operationId="deleteMemberListByID",
     *      tags={"Members"},
     *      summary="deleta as info de um membro",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID do membro",
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
        if(empty($ID)) return response()->json(['error'=> 'Parâmetro inválido'],Response::HTTP_BAD_REQUEST);

        $this->result = $this->memberServices->delete($ID);

        if(isset($this->result['error'])) return response()->json($this->result,Response::HTTP_NOT_FOUND);

        return response()->json($this->result, Response::HTTP_OK);
    }
}
