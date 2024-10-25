<?php

namespace App\Interface;

use App\DTO\MemberDTO;
use App\DTO\MemberCreateDTO;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

interface MemberInterface
{
    public function all():Collection;
    public function create(MemberCreateDTO $dto):MemberDTO;
    public function findMembersByChurchID(string $churchID):Collection;
    public function edit(string $ID):MemberDTO;
    public function update(Request $request, string $ID):array;
    public function delete(string $ID):array;
}
