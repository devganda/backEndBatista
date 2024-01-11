<?php

namespace App\Interface;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ChurchInterface
{
    public function index():JsonResponse;
    public function create(Request $request):JsonResponse;
    public function edit(string $ID):JsonResponse;
    public function update(Request $request, string $ID):JsonResponse;
    public function delete(string $ID):JsonResponse;
}
