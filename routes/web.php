<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//User routes

//kiểm tra đăng nhập
Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');
//đăng ký
Route::post('/register', [UserController::class, "register"])->middleware('guest');
//đăng nhập
Route::post('/login', [UserController::class, "login"])->middleware('guest');
//đăng xuất
Route::post('/logout', [UserController::class, "logout"])->middleware('mustBeLogged');


// Blog post related routes
Route::get('/create-post', [PostController::class, "showCreatePostForm"])->middleware('mustBeLogged');
Route::get('/post/{id}', [PostController::class, "viewSinglePost"])->middleware('mustBeLogged');
Route::post('/create-post', [PostController::class, "storeNewPost"])->middleware('mustBeLogged');

//Profile user
Route::get('/profile/{idUser}', [UserController::class, "profile"]);