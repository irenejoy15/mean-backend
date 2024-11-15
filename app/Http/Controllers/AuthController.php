<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Hash;
use Str;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\User;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
   
    public function login(Request $request){
            $credentials = $request->only('email', 'password');
            $email = $request->input('email');
            $user = auth()->user();
            try {

            if (! $token = auth()->attempt($credentials)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                $irene_user = User::where('email',$email)->first();
                // $token = auth()->login($irene_user);
                $user = auth()->user();
                $token = JWTAuth::fromUser($user);

                $response = Response::json([
                    "user"=>$user,
                    "token"=>$token,
                    // 'authorization' => [
                    //     'token' => $token,
                    //     'type' => 'bearer',
                    // ],
                    'authorization' => $token,
                ], 200);
            } catch (JWTException $e) {
                return response()->json(['error' => 'Could not create token'], 500);
            }

            return $response;
       
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
