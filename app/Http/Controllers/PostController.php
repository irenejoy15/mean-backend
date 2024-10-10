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
        $latest = Post::latest()->first();
        return response()->json([
            'message' => 'IRENE SYPEERRRR',
            'postId'=>$latest->id
        ], 201);
    }

    public function delete($id){
        Post::where('id',$id)->delete();
        return response()->json([
            'message' => 'DELETED',
        ], 200);
    }

    public function edit($id){
        $post_check = Post::where('id',$id)->first();
        $post = array(
            'id'=>$post_check->id,
            'title'=>$post_check->title,
            'content'=>$post_check->content,
        );
        return response()->json($post);
    }

    
    public function posts_search(Request $request){
        $search = $request->input('title');
        if(empty($search)):
            $posts = Post::all();
        else:
            $posts = Post::where('title', 'like', '%'.$search.'%')->get();
        endif;
        return response()->json([
            'posts' => $posts,
            'message' => 'IRENE SYPEERRRR',
        ], 200);
    }
}
