<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Traits\ApiTraits;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class ApiAuthenticateMiddleware extends BaseMiddleware
{
    use ApiTraits;

    public function handle($request, Closure $next)
    { 
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->errorResponse([], "Token is invalid.", Response::HTTP_UNAUTHORIZED);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->errorResponse([], "Error validating access token. Session has expired.", Response::HTTP_UNAUTHORIZED);
            }else{
                return $this->errorResponse([], "Authorization Token not found.", Response::HTTP_BAD_REQUEST);
            }
        }
        return $next($request);
    }
}