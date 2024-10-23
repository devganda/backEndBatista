<?php

namespace App\Interface;

use App\DTO\ChurchDTO;
use App\DTO\ChurchCreateDTO;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;

interface ChurchInterface
{
    public function all():Collection;
    public function create(ChurchCreateDTO $dto):ChurchDTO;
    public function find(string $ID):ChurchDTO;
    public function update(Request $request, string $ID):ChurchDTO;
    public function delete(string $ID):array;
}
