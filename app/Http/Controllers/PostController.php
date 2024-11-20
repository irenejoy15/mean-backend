<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use JWTAuth;
use App\Http\Controllers\BaseController;
use Auth;
class PostController extends BaseController
{
    //

    public function posts(Request $request){
        $token = Auth::user()->currentAccessToken();
        $pageSize = $request->get('pagesize');
        $currentPage = $request->get('page');
        
        $post_query = Post::query();
        
        if($pageSize && $currentPage):
            $skip = $pageSize * ($currentPage-1);
        endif;
        $user = Auth::user(); 
        
        $posts = $post_query->skip($skip)->limit($pageSize)->get();
       
        return response()->json([
            'authorization' => 'Bearer '.$token,
            'posts' => $posts,
            'message' => 'IRENE SYPEERRRR',
            'maxPosts'=>Post::count(),
            'user'=>$user
        ], 200);
    }

    public function create_post(CreatePostRequest $request){
        $token = Auth::user()->currentAccessToken();
        $user = Auth::user();
        $title = $request->input('title');
        $content = $request->input('content');
        $image = $request->file('image');

        $photo_name = time().'.'.$image->extension();
        $image->move('images', $photo_name);
        $photo_image_post = $photo_name;

        $data = array(
            'title'=>$title,
            'content'=>$content,
            'imagePath'=>'http://localhost:82/mean-backend/public/images/'.$photo_image_post,
            'creator'=>$user->id
        );
        Post::create($data);
        $latest = Post::latest()->first();
        return response()->json([
            'message' => 'IRENE SYPEERRRR',
            'authorization' => 'Bearer '.$token,
            'post'=>array(
                'id'=>$latest->id,
                'title'=>$title,
                'content'=>$content,
                'imagePath'=>$photo_image_post,
                'creator'=>$user->id
            )
        ], 201);
    }

    public function delete($id){
        $user = Auth::user();
        $token = Auth::user()->currentAccessToken();
        $post = Post::where('id',$id)->first();
        if($user->id == $post->creator):
            Post::where('id',$id)->delete();
            return response()->json([
                'message' => 'DELETED',
                'authorization' => 'Bearer '.$token
            ], 200);
        else:
            return response()->json([
                'message' => 'NOT AUHTORIZE',
                'authorization' => 'Bearer '.$token
            ], 401);
        endif;
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
        $user = Auth::user();
        $token = Auth::user()->currentAccessToken();

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

        $check_post = Post::where('id',$id)->first();
        if($check_post->creator == $user->id):
            Post::where('id',$id)->update($data);
            return response()->json([
                'message' => 'UPDATE SUCCESSFULLY',
                'authorization' => 'Bearer '.$token
            ], 200);
        else:
            return response()->json([
                'message' => 'NOT AUTHORIZE',
                'authorization' => 'Bearer '.$token
            ], 401);
        endif;
       
    }
    
    public function posts_search(Request $request){
        $search = $request->get('title');
        $pageSize = $request->get('pagesize');
        $currentPage = $request->get('page');

        $token = JWTAuth::getToken();

        $post_query = Post::query();
        
        if($pageSize && $currentPage):
            $skip = $pageSize * ($currentPage-1);
        endif;

        if(empty($search)):
            $posts = $post_query->skip($skip)->limit($pageSize)->get();
            $count =  Post::count();
        else:
            $posts = $post_query->where('title', 'like', '%'.$search.'%')->skip($skip)->limit($pageSize)->get();
            $count =  Post::where('title', 'like', '%'.$search.'%')->count();
        endif;

        return response()->json([
            'posts' => $posts,
            'message' => 'IRENE SYPEERRRR',
            'maxPosts' => $count,
            'authorization' => 'Bearer '.$token
        ], 200);
    }
}
