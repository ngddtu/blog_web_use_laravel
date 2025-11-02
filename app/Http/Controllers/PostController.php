<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function storeNewPost(Request $request){
        
        $data = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $data['title'] = strip_tags($data['title']);
        $data['body'] = strip_tags($data['body']);
        $data['user_id'] = auth()->id();
        
        $newPost = Post::create($data);

        if($newPost){
            return redirect("/post/$newPost->id");
        }else{
            return 'false';
        }
    }
    public function showCreatePostForm(){
        return view('client.create-post');
    }

    //show blog mới đăng
    public function viewSinglePost(Post $id){
        // return $id->title;
        $id['body'] = Str::markdown($id->body);
        return view('client.single-post', ['id' => $id]);
    }
}
