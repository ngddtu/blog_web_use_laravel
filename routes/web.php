<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExampleController;


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
Route::get('/post/{idPost}', [PostController::class, "viewSinglePost"])->middleware('mustBeLogged');
Route::post('/create-post', [PostController::class, "storeNewPost"])->middleware('mustBeLogged');
Route::delete('post/{idPost}', [PostController::class, "delete"])->middleware('can:delete,idPost');
//Show form edit
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, 'update'])->middleware('can:update,post');

//Profile user
Route::get('/profile/{idUser}', [UserController::class, "profile"]);
//manage avatar
Route::get('/manage-avatar', [UserController::class, 'showAvatar'])->middleware('mustBeLogged');
Route::post('/manage-avatar', [UserController::class, 'storeAvatar'])->middleware('mustBeLogged');

//admin route (phát triển sau)
Route::get('/admin-only', function(){
    if(Gate::allows('visitAdminPages')){
        return 'Only admins should be able to see this page';
    }
    return 'You can not view this page';
}) ;// hoặc ->middleware('can:visitAdminPages')