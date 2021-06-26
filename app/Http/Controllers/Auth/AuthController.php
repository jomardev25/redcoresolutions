<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    private $maxAttempts = 3;

    public function __construct()
    {
        $this->middleware('guest')->except('login', 'logout');
    }

    public function login(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($token = auth('api')->attempt($this->credentials($request))){
                $request->session()->regenerate();
                $this->clearLoginAttempts($request);
                return $this->respondWithToken($token);
            }

            $this->incrementLoginAttempts($request);
            return $this->errorResponse([], __('auth.failed'), Response::HTTP_FORBIDDEN);
        }

        $this->incrementLoginAttempts($request);
        return $this->errorResponse([], __('auth.failed'), Response::HTTP_FORBIDDEN);
    }

    public function check()
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return $this->errorResponse(['authenticated' => false], 'Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
        return $this->successResponse(['authenticated' => true]);
    }

    public function logout()
    {
        auth()->logout();
        return $this->successResponse(null, 'Successfully logged out.');
    }

    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    protected function respondWithToken($token)
    {
        $user = auth()->user()->load('role');

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $user,
            'status' => 200
        ]);
    }
}
