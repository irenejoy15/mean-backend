<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
{
    //

    public function posts(){
        $posts = Post::all();
        return response()->json([
            'posts' => $posts,
            'message' => 'IRENE SYPEERRRR',
        ], 200);
    }

    public function create_post(Request $request){
        $title = $request->input('title');
        $content = $request->input('content');

        $data = array(
            'title'=>$title,
            'content'=>$content,
        );
        Post::create($data);
        return response()->json([
            'message' => 'IRENE SYPEERRRR',
        ], 201);
    }
}
