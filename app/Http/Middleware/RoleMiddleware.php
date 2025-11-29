<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class RoleMiddleware
{

    public function handle($request, \Closure $next, $role)
    {

        $user = auth('api')->user();

        if ($user->role->name !== $role) {
            throw new AuthorizationException('You do not have permission to perform this action.');
        }
        return $next($request);
    }
}
