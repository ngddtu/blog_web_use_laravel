<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    //hàm check điều hướng
    public function showCorrectHomepage(){
        if(auth()->check()){
            return view('client.homepage-feed');
        } else{
            return view('client.homepage');
        }
    }
    
    //hàm đăng ký
    public function register(Request $request){
        $data = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        $user = User::create($data);
        auth()->login($user);
        return redirect('/')->with('success', 'Thank you for creating an account');
    }

    //hàm đăng nhập
    public function login(Request $request){
        $data = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);
        // var_dump($data);
        // die();
        if(auth()->attempt(['username' => $data['loginusername'], 'password' => $data['loginpassword']])){
            $request->session()->regenerate();
            return redirect('/')->with('success','You are now logged in.');  //-------------xem ghi chú ngày 1/11----------
        } else {
            return redirect('/')->with('error','Invalid login.');
        }
    }

    //hàm đăng xuất
    public function logout(){
        auth()->logout();
        return redirect('/')->with('success','You are now logged out.');
    }

    //hàm show profile-post
    public function profile(User $idUser)  {
        $thePosts = $idUser->getPostByIdUser()->latest()->get();
        $postCount = $idUser->getPostByIdUser()->count();
        
        return view('client.profile-posts', compact('thePosts', 'postCount', 'idUser'));
    }

    //hàm show avatar 
    public function showAvatar() {
        return view('client.avatar-form');
    }

    //handle avatar
    public function storeAvatar(Request $request) {
        $request->validate([
            'avatar' => 'required|image|max:3000'
        ]);

        $request->file('avatar')->store('user', 'public');
    }
}
