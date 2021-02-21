<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForumController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/**
 *  Redirect to main page for default address
 */
Route::get('/', function () {
    return view('main');
})->name('main');


/**
 *  Routes that need authentication
 */
Route::get('/views/login', function () {
    if (Auth::check())
        return redirect()->intended();
    else
        return view('login');
})->name('login');


Route::post('/logout', [LoginController::class, 'logout']);



/**
 *  View Routes
 *  Return views from blade tempaltes
 */
Route::get('/views/broadcast', function () {
    return view('broadcast');
})->middleware('auth');


Route::get('/views/createpost', function () {
    return view('createpost');
})->middleware('auth');


Route::post('/auth', [LoginController::class, 'authenticate']);

/* Routes for views that do not require authentication */
Route::get('/views/{php_view_file}', function ($php_view_file) {
    return view($php_view_file);
});




/**
 *  REST API calls
 * ----------------------------------------
 *
 *  See REST API Documentation for details.
 */

/* User information CRUD */
Route::get('/members/{username}', [UserController::class, 'get_user']) ->middleware('auth');
Route::post('/members/{username}', [UserController::class, 'register_user']);
Route::put('/members/{username}', [UserController::class, 'update_user']) ->middleware('auth');
Route::delete('/members/{username}', [UserController::class, 'remove_user']) ->middleware('auth');

Route::get('/forum/{forum_name}/post/{post_id}', [ForumController::class, 'retrieve_post']);
Route::get('/forum/{forum_name}/page/{page}', [ForumController::class, 'get_posts_in_page']);
Route::post('/forum/{forum_name}/post', [ForumController::class, 'create_post']);
Route::put('/forum/{forum_name}/post/{post_id}', [ForumController::class, '']);
Route::delete('/forum/{forum_name}/post/{post_id}', [ForumController::class, '']);
Route::post('/support_request', [ForumController::class, 'request_support']);

Route::get('/friends', [UserController::class,'get_friends']) ->middleware('auth');
Route::post('/friend/{uid}', [UserController::class, 'add_friend']) ->middleware('auth');
Route::put('/friend/{uid}', [UserController::class, 'respond_friend_request']) ->middleware('auth');
Route::delete('/friend/{uid}', [UserController::class, 'delete_friend']) ->middleware('auth');

Route::get('/members/guardians', [UserController::class,'get_guardians']) ->middleware('auth');
Route::post('/members/guardian/{uid}', [UserController::class,'add_guardian']) ->middleware('auth');
Route::put('/members/guardian/{uid}', [UserController::class,'confirm_guardian_request']) ->middleware('auth');
Route::delete('/members/guardian/{uid}', [UserController::class,'delete_guardian']) ->middleware('auth');

Route::get('/members/protecteds', [UserController::class,'get_protecteds']) ->middleware('auth');
Route::post('/members/protected/{uid}', [UserController::class,'add_protected']) ->middleware('auth');
Route::put('/members/protected/{uid}', [UserController::class,'confirm_protected_request']) ->middleware('auth');
Route::delete('/members/protected/{uid}', [UserController::class,'delete_protected']) ->middleware('auth');

Route::post('/emergency/report', [UserController::class,'emergency_report']) ->middleware('auth');
Route::get('/emergency/{uid}/status', [UserController::class,'get_status']) ->middleware('auth');
Route::get('/emergency/{uid}/stream_key', [UserController::class,'get_streamkey']) ->middleware('auth');
