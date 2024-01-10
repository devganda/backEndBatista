<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Api batista",
 *      description="A api fornece e guarda dados relacionados as igrejas, bem como dados de membros, pastores e etc.. ",
 *      @OA\Contact(
 *          email="daniloganda95@gmail.com",
 *          name="Danilo"
 *      ),
 *      @OA\License(
 *          name="batista",
 *          url="#"
 *      )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
