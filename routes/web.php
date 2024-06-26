<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;


Route::get('/', [HomeController::class, 'getHome'])->name('home');

// Post
Route::get('/post', [PostController::class, 'getIndex'])->name('post.index');

Route::get('/post/search', [PostController::class, 'search'])->name('posts.search');

Route::get('/post/show/{id}', [PostController::class, 'getShow'])->name('post.show');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('post.show');
Route::get('/post/create', [PostController::class, 'getCreate'])->name('post.create');
Route::post('/post', [PostController::class, 'store'])->name('post.store');


Route::get('/post/edit/{id}', [PostController::class, 'getEdit'])->name('post.edit');

Route::put('/post/{id}', [PostController::class, 'update'])->name('post.update');

Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');

//Myposts
Route::get('/myposts', [PostController::class, 'showMyPosts'])->name('post.myposts');


Route::get('/myposts/search', [PostController::class, 'searchMyPosts'])->name('myposts.search');
//Category
Route::resource('categories', CategoryController::class);
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
//Profile 
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
// Breeze routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php'; 



Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Home Routes
     */
    Route::get('/home', 'HomeController@getHome')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});
Route::post('/post/{post}/like', [PostController::class, 'likePost'])->name('post.like');
Route::delete('/post/{post}/unlike', [PostController::class, 'unlikePost'])->name('post.unlike');
