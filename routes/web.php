<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('Post', PostController::class);
Route::get('Like/{Post}', [PostController::class,'Like'])->name('Like');
Route::get('UnLike/{Post}', [PostController::class,'UnLike'])->name('Un-Like');

Route::post('Comment/{Post}', [CommentController::class,'store'])->name('Comment.Add');
Route::get('Comment/Delete/{Comment}', [CommentController::class,'destroy'])->name('Comment.Delete');

Route::get('Media/{Media}',[MediaController::class,'destroy'])->name('RemoveMedia');
