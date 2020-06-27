<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use App\Model\Constant;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['error' => Constant::MESSAGE_TOKEN_INVALID], 401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['error' => Constant::MESSAGE_TOKEN_EXPIRED], 401);
            }else{
                return response()->json(['error' => Constant::MESSAGE_TOKEN_ABSENT], 401);
            }
        }
        return $next($request);
    }
}
