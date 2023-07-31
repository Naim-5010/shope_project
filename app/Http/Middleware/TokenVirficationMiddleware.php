<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVirficationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 👑👑 for the postman parpas
        // $token = $request->header('token');

        // for the web parpas
        $token = $request->cookie('token');
        $result = JWTToken::VerifyToken($token);
        if ($result == "unauthorized") {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ], 401);
         }
         else{
            $request->headers->set('email', $result);
            return $next($request);
         }


       
    }
}
