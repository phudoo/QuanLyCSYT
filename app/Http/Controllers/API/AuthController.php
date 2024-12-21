<?php

namespace App\Http\Controllers\API;
  
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
  
class AuthController extends BaseController
{
 
    
  
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
{
    $credentials = request(['username', 'password']);

    // Sử dụng guard 'api' với driver 'jwt'
    if (!$token = auth('api')->attempt($credentials)) {
        return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
    }

    return response()->json([
        'success' => true,
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth('api')->factory()->getTTL() * 60,
    ]);
}


  
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $success = auth()->user();
   
        return $this->sendResponse($success, 'Refresh token return successfully.');
    }
  
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        
        return $this->sendResponse([], 'Successfully logged out.');
    }
  
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $success = $this->respondWithToken(auth()->refresh());
   
        return $this->sendResponse($success, 'Refresh token return successfully.');
    }
  
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
