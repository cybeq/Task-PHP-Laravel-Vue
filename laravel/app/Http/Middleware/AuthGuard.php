<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
class AuthGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('testing')) {
            return $next($request);
        }
        $authorizationKey = $request->header('Authorization');
        $secret = env('JWT_SECRET');
        $payload = false;
        try {
            $payload = JWT::decode($authorizationKey, new Key($secret, 'HS256'));
        } catch (Exception $e) {
        }
        if($payload) {
            return $next($request);
        }
        return \response()->json(['fail'=>'auth']);

    }
}
