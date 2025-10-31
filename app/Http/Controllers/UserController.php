<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //

    public function showCorrectHomepage(){
        if(auth()->check()){
            return view('client.homepage-feed');
        } else{
            return view('client.homepage');
        }
    }
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

    public function login(Request $request){
        $data = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);
        // var_dump($data);
        // die();
        if(auth()->attempt(['username' => $data['loginusername'], 'password' => $data['loginpassword']])){
            $request->session()->regenerate();
            return redirect('/')->with('success','You are now logged in.');
        } else {
            return redirect('/')->with('error','Invalid login.');
        }
    }

    public function logout(){
        auth()->logout();
        return redirect('/')->with('success','You are now logged out.');
    }
}
