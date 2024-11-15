<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller 
{
    public function signup(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        $hash_password = bcrypt($password);

        $user = User::create([
            'email'=>$email,
            'password'=>$hash_password,
        ]);

        return  response()->json([
            'result'=>$user,
            // 'token'=>$token,
            // 'authorization' => 'Bearer '.$token,
            'message'=>'USER CREATED'
        ], 201);
    }
}
 