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
            // Check for branches
            $branches = $request->user()->branches;

            if (!empty($branches->toArray())) {
                setPermissionsTeamId($request->user()->branches[0]);
            }
        }

        return $next($request);
    }
}
