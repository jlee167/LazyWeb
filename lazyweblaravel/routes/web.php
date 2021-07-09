<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\StreamController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
})->middleware('xss')->name('login');


Route::get('/views/google2fa', function () {
    return view('google2fa');
})->middleware(['xss', 'auth', 'verified'])->name('2fa');


Route::get('/views/register', function () {
    if (Auth::check())
        return redirect()->intended();
    else
        return view('register');
})->middleware('xss')->name('register');


Route::post('/logout',      [LoginController::class, 'logout']);
Route::post('/auth',        [LoginController::class, 'authenticate'])->middleware('xss');
Route::post('/auth/kakao',  [LoginController::class, 'authWithKakao'])->middleware('xss');
Route::post('/auth/google', [LoginController::class, 'authWithGoogle'])->middleware('xss');


Route::get('/members/2fa-key', [UserController::class, 'enable2FA'])->middleware(['xss', 'auth', 'verified']);
Route::delete('/members/2fa-key', [UserController::class, 'disable2FA'])->middleware(['xss', 'auth', 'verified', '2fa']);
Route::put('/members/password', [UserController::class, 'changePassword'])->middleware(['xss', 'auth', 'verified', '2fa']);

Route::post('/auth/2fa', [LoginController::class, 'authWithGoogle2FA'])->middleware(['xss', 'auth', 'verified']);


Route::get('/email/resend', [UserController::class, 'resendEmail'])
    ->middleware(['xss', 'auth', 'throttle:6,1'])->name('verification.send');


Route::get('/email/verify', function () {
    return view('verify-email');
})->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/views/main');
})->middleware(['auth'])->name('verification.verify');



/* -------------------------------------------------------------------------- */
/*                           /Authentication Routes                           */
/* -------------------------------------------------------------------------- */





/* -------------------------------------------------------------------------- */
/*                                 View Routes                                */
/* -------------------------------------------------------------------------- */

Route::get('/views/broadcast', function () {
    return view('broadcast');
})->middleware(['xss', 'auth', 'verified', '2fa']);


Route::get('/views/emergency_broadcast', function () {
    return view('emergency_broadcast');
})->middleware(['xss', 'auth', 'verified', '2fa']);


Route::get('/views/createpost', function () {
    return view('createpost');
})->middleware(['xss', 'auth', 'verified', '2fa']);


Route::get('/views/peers', function () {
    return view('peers');
})->middleware(['xss', 'auth', 'verified', '2fa']);


/* Routes for views that do not require authentication */
Route::get('/views/{php_view_file}', function ($php_view_file) {
    return view($php_view_file);
});

/* -------------------------------------------------------------------------- */
/*                                /View Routes                                */
/* -------------------------------------------------------------------------- */





/* -------------------------------------------------------------------------- */
/*                               REST API Routes                              */
/* -------------------------------------------------------------------------- */


/* --------------------------- Server Status Check -------------------------- */
Route::get('/ping', function () {
    return "Lazyboy Web Server is running!";
});


/* -------------------------- User information CRUD ------------------------- */
Route::get('/members/{username}', [UserController::class, 'getUser'])->middleware(['xss', 'auth', 'verified', '2fa']);
Route::post('/members/{username}', [UserController::class, 'registerUser']);
Route::put('/members', [UserController::class, 'updateUser'])->middleware(['xss', 'auth', 'verified', '2fa']);
Route::delete('/members', [UserController::class, 'deleteUser'])->middleware(['xss', 'auth']);

Route::get(
    '/self/uid',
    function () {
        if (!Auth::check())
            return null;
        return Auth::id();
    }
)->middleware(['auth', 'verified']);

Route::get('/self', [UserController::class, 'getMyInfo'])->middleware(['auth', 'verified']);

Route::get('/members/uid/{username}', [UserController::class, 'getUserId'])->middleware(['auth', 'verified']);



/* ------------------------------- Forum CRUD ------------------------------- */
Route::get('/forum/{forum_name}/post/{post_id}',        [ForumController::class, 'getPost']);
Route::post('/forum/{forum_name}/post',                 [ForumController::class, 'createPost'])->middleware('xss-soft');
Route::put('/forum/{forum_name}/post/{post_id}',        [ForumController::class, 'updatePost']);
Route::delete('/forum/{forum_name}/post/{post_id}',     [ForumController::class, 'deletePost']);

Route::post('/forum/{forum_name}/post/{post_id}/like',  [ForumController::class, 'togglePostLike']);

Route::post('/forum/comment',                   [ForumController::class, 'postComment'])->middleware(['xss-soft', 'auth', 'verified', '2fa']);
Route::put('/forum/comment/{comment_id}',       [ForumController::class, 'updateComment'])->middleware(['xss-soft', 'auth', 'verified', '2fa']);
Route::delete('/forum/comment/{comment_id}',    [ForumController::class, 'deleteComment'])->middleware(['xss-soft', 'auth', 'verified', '2fa']);

Route::get('/forum/{forum_name}/page/{page}/{keyword}',   [ForumController::class, 'getPage']);
Route::get('/forum/all_forums/top_posts',                 [ForumController::class, 'getTopPosts']);
Route::get('/forum/all_forums/trending_posts',            [ForumController::class, 'getTrendingPosts']);


/* ---------------------------- Support requests ---------------------------- */
Route::post('/support_request',    [SupportController::class, 'requestSupport'])->middleware('xss-soft');


/* ----------------------- Guardianship Management API ---------------------- */
Route::get('/members/guardian/all',         [UserController::class, 'getGuardians'])        ->middleware(['xss', 'auth', 'verified', '2fa']);
Route::post('/members/guardian/{uid}',      [UserController::class, 'addGuardian'])         ->middleware(['xss', 'auth', 'verified', '2fa']);
Route::put('/members/guardian/{uid}',       [UserController::class, 'acceptGuardian'])      ->middleware(['xss', 'auth', 'verified', '2fa']);
Route::delete('/members/guardian/{uid}',    [UserController::class, 'deleteGuardian'])      ->middleware(['xss', 'auth', 'verified', '2fa']);
Route::get('/members/protected/all',        [UserController::class, 'getProtecteds'])       ->middleware(['xss', 'auth', 'verified', '2fa']);
Route::post('/members/protected/{uid}',     [UserController::class, 'addProtected'])        ->middleware(['xss', 'auth', 'verified', '2fa']);
Route::put('/members/protected/{uid}',      [UserController::class, 'acceptProtected'])     ->middleware(['xss', 'auth', 'verified', '2fa']);
Route::delete('/members/protected/{uid}',   [UserController::class, 'deleteProtected'])     ->middleware(['xss', 'auth', 'verified', '2fa']);
Route::put('/peer_request',                 [UserController::class, 'respondPeerRequest'])  ->middleware(['xss', 'auth', 'verified', '2fa']);
Route::get('/pending_requests',             [UserController::class, 'getPendingRequests'])  ->middleware(['xss', 'auth', 'verified', '2fa']);


/* ---------------------------- Emergency Actions --------------------------- */
Route::post('/emergency/report',                    [UserController::class,   'emergencyReport'])   ->middleware(['xss', 'auth', 'verified', '2fa']);
Route::get('/emergency/{username}/status',          [UserController::class,   'getStatus'])         ->middleware(['xss', 'auth', 'verified', '2fa']);
Route::get('/stream/{username_protected}/web_token',          [StreamController::class, 'getWebToken'])       ->middleware(['xss', 'auth', 'verified', '2fa']);
Route::get('/stream/{uid_protected}',                         [StreamController::class, 'getStream'])         ->middleware(['xss', 'auth', 'verified', '2fa']);


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
