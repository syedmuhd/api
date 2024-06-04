<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTeamId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty($request->user())) {
            // Check for branches
            $teamId = $request->user()->team_id;

            if ($teamId) {
                setPermissionsTeamId($teamId);
            }
        }

        return $next($request);
    }
}
