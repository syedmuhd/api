<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BranchPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty($request->user())) {
            // `getTeamIdFromToken()` example of custom method for getting the set team_id 
            setPermissionsTeamId(auth('api')->user()->getTeamIdFromToken());
            echo "asd2";
            exit;
        }

        return $next($request);
    }
}
