<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //

    public function posts(){
        $posts[] = array(
            'id'=>'1',
            'title'=>'irene1',
            'content'=>'irene2',
        );
        return response()->json([
            'posts' => $posts,
            'message' => 'IRENE SYPEERRRR',
        ], 200);
    }

    public function create_post(Request $request){
        return response()->json([
            'message' => 'IRENE SYPEERRRR',
        ], 201);
    }
}
