<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class CheckMultiplePermissions
{
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        foreach ($permissions as $permission) {
            if (Gate::allows($permission)) {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Unauthorized action.'], 403);
    }
}
