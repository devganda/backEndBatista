<?php

namespace App\Interface;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;

interface MemberInterface
{
    public function all():Collection;
    public function create(Request $request):array;
    public function findMembersByChurchID(string $churchID):array;
    public function edit(string $ID):array;
    public function update(Request $request, string $ID):array;
    public function delete(string $ID):array;
}
