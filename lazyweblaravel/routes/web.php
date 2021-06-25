<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\StreamController;

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


/* Default Routes */

Route::get('/', function () {
    return view('main');
})->name('main');




/* -------------------------------------------------------------------------- */
/*                            Authentication Routes                           */
/* -------------------------------------------------------------------------- */

Route::get('/views/login', function () {
    if (Auth::check())
        return redirect()->intended();
    else
        return view('login');
})->name('login');


Route::get('/views/register', function () {
    if (Auth::check())
        return redirect()->intended();
    else
        return view('register');
})->name('register');


Route::post('/logout',      [LoginController::class, 'logout']);
Route::post('/auth',        [LoginController::class, 'authenticate']);
route::post('/auth/kakao',  [LoginController::class, 'authWithKakao']);
route::post('/auth/google', [LoginController::class, 'authWithGoogle']);


/* -------------------------------------------------------------------------- */
/*                           /Authentication Routes                           */
/* -------------------------------------------------------------------------- */





/* -------------------------------------------------------------------------- */
/*                                 View Routes                                */
/* -------------------------------------------------------------------------- */

Route::get('/views/broadcast', function () {
    return view('broadcast');
})->middleware('auth');


Route::get('/views/emergency_broadcast', function () {
    return view('emergency_broadcast');
})->middleware('auth');


Route::get('/views/createpost', function () {
    return view('createpost');
})->middleware('auth');


Route::get('/views/peers', function () {
    return view('peers');
})->middleware('auth');


/* Routes for views that do not require authentication */
Route::get('/views/{php_view_file}', function ($php_view_file) {
    return view($php_view_file);
});

/* -------------------------------------------------------------------------- */
/*                                /View Routes                                */
/* -------------------------------------------------------------------------- */





/* -------------------------------------------------------------------------- */
/*                               Rest API Routes                              */
/* -------------------------------------------------------------------------- */


/* --------------------------- Server Status Check -------------------------- */
Route::get('/ping', function () {
    return "Lazyboy Web Server is running!";
});


/* -------------------------- User information CRUD ------------------------- */
Route::get('/members/{username}', [UserController::class, 'getUser'])->middleware('auth');
Route::post('/members/{username}', [UserController::class, 'registerUser']);
Route::put('/members/{username}', [UserController::class, 'updateUser'])->middleware('auth');
Route::delete('/members/{username}', [UserController::class, 'deleteUser'])->middleware('auth');

Route::get(
    '/self/uid',
    function () {
        if (!Auth::check())
            return null;
        return Auth::id();
    }
)->middleware('auth');

Route::get(
    '/self',
    function () {
        if (!Auth::check())
            return null;
        return json_encode(Auth::user());
    }
)->middleware('auth');;

Route::get('/members/uid/{username}', [UserController::class, 'getUserId'])->middleware('auth');



/* ------------------------------- Forum CRUD ------------------------------- */
Route::get('/forum/{forum_name}/post/{post_id}',  [ForumController::class, 'retrievePost']);
Route::post('/forum/{forum_name}/post',            [ForumController::class, 'createPost']);
Route::put('/forum/{forum_name}/post/{post_id}',  [ForumController::class, 'updatePost']);
Route::delete('/forum/{forum_name}/post/{post_id}',  [ForumController::class, 'deletePost']);

Route::post('/forum/{forum_name}/post/{post_id}/like',  [ForumController::class, 'toggleLike']);

Route::post('/forum/comment',                      [ForumController::class, 'postComment'])->middleware('auth');
Route::put('/forum/comment/{comment_id}',         [ForumController::class, 'updateComment'])->middleware('auth');
Route::delete('/forum/comment/{comment_id}',         [ForumController::class, 'deleteComment'])->middleware('auth');

Route::get('/forum/{forum_name}/page/{page}/{keyword}',   [ForumController::class, 'getPage']);
Route::get('/forum/all_forums/top_posts',                 [ForumController::class, 'getTopPosts']);
Route::get('/forum/all_forums/trending_posts',            [ForumController::class, 'getTrendingPosts']);


/* ---------------------------- Support requests ---------------------------- */
Route::post('/support_request',    [SupportController::class, 'requestSupport']);


/* ----------------------- Guardianship Management API ---------------------- */
Route::get('/members/guardian/all',       [UserController::class, 'getGuardians'])->middleware('auth');
Route::post('/members/guardian/{uid}',     [UserController::class, 'addGuardian'])->middleware('auth');
Route::put('/members/guardian/{uid}',     [UserController::class, 'acceptGuardian'])->middleware('auth');
Route::delete('/members/guardian/{uid}',     [UserController::class, 'deleteGuardian'])->middleware('auth');
Route::get('/members/protected/all',      [UserController::class, 'getProtecteds'])->middleware('auth');
Route::post('/members/protected/{uid}',    [UserController::class, 'addProtected'])->middleware('auth');
Route::put('/members/protected/{uid}',    [UserController::class, 'acceptProtected'])->middleware('auth');
Route::delete('/members/protected/{uid}',    [UserController::class, 'deleteProtected'])->middleware('auth');
Route::put('/peer_request',               [UserController::class, 'respondPeerRequest'])->middleware('auth');
Route::get('/pending_requests',           [UserController::class, 'getPendingRequests'])->middleware('auth');


/* ---------------------------- Emergency Actions --------------------------- */
Route::post('/emergency/report',               [UserController::class, 'emergency_report'])->middleware('auth');
Route::get('/emergency/{username}/status',         [UserController::class, 'getStatus'])->middleware('auth');
Route::get('/emergency/{username}/web_token',   [StreamController::class, 'getWebToken'])->middleware('auth');


/* -------------------------------------------------------------------------- */
/*                              /Rest API Routes                              */
/* -------------------------------------------------------------------------- */




/* -------------------------------------------------------------------------- */
/*                              Debugging Routes                              */
/* -------------------------------------------------------------------------- */

if (env('APP_ENV') != 'production') {

    /* SQL Injection Simulation */
    route::post('/sqltest', function (Request $request) {
        $mysqli = new mysqli("localhost", "root", "", "lazyboyserver");
        // Check connection
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }
        //return "SELECT id FROM users where username = '{$request->input("query")}';";
        // Perform query
        if ($result = $mysqli->query("SELECT id FROM users where username = '{$request->input("query")}';")) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $myArray[] = $row;
            }
            echo json_encode($myArray);
        } else {
            echo 'NOOOO';
        }

        $mysqli->close();
    });
}


/* -------------------------------------------------------------------------- */
/*                             /Debugging Routes                              */
/* -------------------------------------------------------------------------- */
