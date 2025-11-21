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
    public function viewSinglePost(Post $idPost){
        // return $id->title;
        $idPost['body'] = Str::markdown($idPost->body);
        return view('client.single-post', ['idPost' => $idPost]);
    }

    //xóa bài viết
    public function delete(Post $idPost)  {
        // if(auth()->user()->cannot('delete', $idPost)){
        //     return 'You cannot do that';
        // } 
        //có thể dùng policy ở controller như trên hoặc dùng trong middleware.
        $idPost->delete();
        return redirect('/profile/' . auth()->user()->id)->with('success', 'Post successfully deleted.');
        
    }

    //show edit form
    public function showEditForm(Post $post){
        // echo'<pre>';
        // var_dump($post->body);
        // die();
        return view('client.edit-post', compact('post'));
    }

    //handle update
    public function update(Post $post, Request $request) {
        $data = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $data['title'] = strip_tags($data['title']);
        $data['body'] = strip_tags($data['body']);

        $post->update($data);
        return back()->with('success','Post successfully updated');
    }
}
