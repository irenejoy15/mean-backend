<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
class PostController extends Controller
{
    //

    public function posts(Request $request){
        $page = $request->get('pageSize');
        $limit = $request->get('limit');

        $post_query = Post::query();
        
        if($page):
            $page = $page;
        else:
            $page = 1;
        endif;

        if($limit):
            $limit = $limit;
        else:
            $limit = 2;
        endif;

        $skip = ($page - 1) * $limit;
        $posts = $post_query->skip($skip)->limit($limit)->get();
        return response()->json([
            'posts' => $posts,
            'message' => 'IRENE SYPEERRRR',
        ], 200);
    }

    public function create_post(CreatePostRequest $request){
        $title = $request->input('title');
        $content = $request->input('content');
        $image = $request->file('image');

        $photo_name = time().'.'.$image->extension();
        $image->move('images', $photo_name);
        $photo_image_post = $photo_name;

        $data = array(
            'title'=>$title,
            'content'=>$content,
            'imagePath'=>'http://localhost:82/mean-backend/public/images/'.$photo_image_post
        );
        Post::create($data);
        $latest = Post::latest()->first();
        return response()->json([
            'message' => 'IRENE SYPEERRRR',
            'post'=>array(
                'id'=>$latest->id,
                'title'=>$title,
                'content'=>$content,
                'imagePath'=>$photo_image_post
            )
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
            'imagePath'=>$post_check->imagePath
        );
        return response()->json($post);
    }
    
    public function edittest($id){
        $post_check = Post::where('id',$id)->first();
        $post = array(
            'id'=>$post_check->id,
            'title'=>$post_check->title,
            'content'=>$post_check->content,
            'imagePath'=>$post_check->imagePath
        );
        return response()->json($post);
    }

    public function update(CreatePostRequest $request,$id){
        $title = $request->input('title');
        $content = $request->input('content');
        $image = $request->file('image');

        if(!empty($image)):
            $photo_name = time().'.'.$image->extension();
            $image->move('images', $photo_name);
            $photo_image_post = $photo_name;

            $data = array(
                'title'=>$title,
                'content' => $content,
                'imagePath'=>'http://localhost:82/mean-backend/public/images/'.$photo_image_post
            );
        else:
            $data = array(
                'title'=>$title,
                'content' => $content
            );
        endif;

        Post::where('id',$id)->update($data);
        return response()->json([
            'message' => 'UPDATE SUCCESSFULLY',
        ], 200);
    }
    
    public function posts_search(Request $request){
        $search = $request->get('title');
        $page = $request->get('pageSize');
        $limit = $request->get('limit');

        $post_query = Post::query();
        
        if($page):
            $page = $page;
        else:
            $page = 1;
        endif;

        if($limit):
            $limit = $limit;
        else:
            $limit = 2;
        endif;

        $skip = ($page - 1) * $limit;
       
        if(empty($search)):
            $posts = $post_query->skip($skip)->limit($limit)->get();
        else:
            $posts = $post_query->where('title', 'like', '%'.$search.'%')->skip($skip)->limit($limit)->get();
        endif;
        return response()->json([
            'posts' => $posts,
            'message' => 'IRENE SYPEERRRR',
        ], 200);
    }
}
