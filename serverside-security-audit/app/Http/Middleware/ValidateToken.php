<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorization = $request -> header("Authorization");
        if ($authorization && str_starts_with($authorization, "Bearer ")) {
            $token = substr($authorization, 7);
            if ($token === env("API_TOKEN")) {
                return $next($request);
            }
        }
        return response() -> json(["message" => "Not authorized"], Response::HTTP_UNAUTHORIZED);
    }
}
