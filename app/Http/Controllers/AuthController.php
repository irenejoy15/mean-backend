<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Hash;
use Auth;
use JWTAuth;
use Str;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email',$email)->first();    

        if(!$user):
            return Response::json([
                'msg'=>'Invalid Credentials',
                'errors' => 'Invalid Credentials' ,
                'status' => true
            ], 401);
        endif;
        $minutes = 60;
      
        if (Hash::check($password, $user->password)):
            $token = Auth::login($user);
            $response = Response::json([
                // $user,
                "token"=>$user->createToken('mean-backend')->plainTextToken,
                // 'authorization' => [
                //     'token' => $token,
                //     'type' => 'bearer',
                // ],
                'authorization' => 'Bearer '.$token,
            ], 200);
           

            return $response;
        else:
            return Response::json([
                'message'=>'Password does not match',
            ], 401);
        endif;
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
