<?php

namespace App\Interface;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;

interface ChurchInterface
{
    public function all():Collection;
    public function create(Request $request):array;
    public function find(string $ID):array;
    public function update(Request $request, string $ID):array;
    public function delete(string $ID):array;
}
