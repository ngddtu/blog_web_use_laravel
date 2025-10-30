<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{   
    public function homePage(){
        return view('client.homepage');
    }
    public function aboutPage(){
        return view('client.single-post');
    }
}
