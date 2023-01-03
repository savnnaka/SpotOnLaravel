<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Route for guest users:
use App\Http\Controllers\HomeController;
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(['guest:web']);

// Search 
use App\Http\Controllers\SearchController;
Route::get('/search', [SearchController::class, 'search'])->name('search');


// Routes for users:
use App\Http\Controllers\User\UserController;

Route::prefix('user')->name('user.')->group(function(){

    // user is not logged in 
    Route::middleware(['guest:web'])->group(function(){
        Route::view('/login', 'user.login')->name('login');
        Route::view('/register', 'user.register')->name('register');
        Route::post('/create', [UserController::class, 'create'])->name('create');
        Route::post('/dologin', [UserController::class, 'dologin'])->name('dologin');
        Route::get('/verify', [UserController::class, 'verify'])->name('verify');
        Route::get('/password/forgot', [UserController::class, 'showForgotForm'])->name('forgot.password.form');
        Route::post('/password/forgot', [UserController::class, 'sendResetLink'])->name('forgot.password.link');
        Route::get('/password/reset/{token}', [UserController::class, 'showResetForm'])->name('reset.password.form');
        Route::post('/password/reset', [UserController::class, 'resetPassword'])->name('reset.password');

    });
    // user is logged in
    Route::middleware(['auth:web', 'is_user_verified'])->group(function(){
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        Route::get('/', [UserController::class, 'index'])->name('home');
    });

});

// Routes for organizers:
use App\Http\Controllers\Organizer\OrganizerController;

Route::prefix('organizer')->name('organizer.')->group(function(){

    // inside prefix organizer we want two routes: one for guests and one for auths
    Route::middleware(['guest:organizer'])->group(function(){
        Route::view('/login', 'organizer.login')->name('login');
        Route::view('/register', 'organizer.register')->name('register');
        Route::post('/create', [OrganizerController::class, 'create'])->name('create');
        Route::post('/dologin', [OrganizerController::class, 'dologin'])->name('dologin');
        Route::get('/verify', [OrganizerController::class, 'verify'])->name('verify');
        Route::get('/password/forgot', [OrganizerController::class, 'showForgotForm'])->name('forgot.password.form');
        Route::post('/password/forgot', [OrganizerController::class, 'sendResetLink'])->name('forgot.password.link');
        Route::get('/password/reset/{token}', [OrganizerController::class, 'showResetForm'])->name('reset.password.form');
        Route::post('/password/reset', [OrganizerController::class, 'resetPassword'])->name('reset.password');
    });
    Route::middleware(['auth:organizer', 'is_organizer_verified'])->group(function(){
        Route::get('/', [OrganizerController::class, 'index'])->name('home');
        Route::post('/logout', [OrganizerController::class, 'logout'])->name('logout');
    });

});


// Routes for Events

use App\Http\Controllers\EventsController;

Route::resource('event', EventsController::class); //Middleware is in constructor


// Routes for OrganizerProfiles

use App\Http\Controllers\OrganizerProfilesController;

Route::get('/organizer-profile/{organizerProfile}', [OrganizerProfilesController::class, 'show']);
Route::get('/organizer-profile/{organizerProfile}/edit', [OrganizerProfilesController::class, 'edit']);
Route::patch('/organizer-profile/{organizerProfile}', [OrganizerProfilesController::class, 'update']);


// Routes for Follows

use App\Http\Controllers\FollowsController;
Route::post('follow/{organizerProfile}', [FollowsController::class, 'store']);

// Routes for Likes

use App\Http\Controllers\LikesController;
Route::post('likes/{event}', [LikesController::class, 'store']);

// Routes for Comments

use App\Http\Controllers\CommentController;
// Route::post('comment/store', [CommentController::class, 'store']);
// Route::get('comment/{comment}/edit', [CommentController::class, 'edit']);
// Route::patch('comment/{comment}', [CommentController::class, 'update']);
Route::resource('comment', CommentController::class);