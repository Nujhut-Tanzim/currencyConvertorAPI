<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyKeyMiddileWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = env("APIKey");
        $keyquery = $request->header("Authorization");
        if ($key != $keyquery) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
