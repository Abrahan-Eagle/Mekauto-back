<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Emails\EmailValidationController;
use App\Http\Controllers\Emails\RecoverPasswordController;
use App\Http\Controllers\Store\PostsController;
use App\Http\Controllers\Store\NoteController;


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
//GOOGLE
Route::post('/auth/googleUser', [AuthController::class, 'googleUser']);
//EMAIL ACTIVATION
//Route::post('/send-email-validation', [EmailValidationController::class, 'index'])->name('send-email-validation');
Route::post('/send-email-validation', [EmailValidationController::class, 'index'])->name('send-email-validation');
Route::get('/email-activation/{token}', [AuthController::class, 'update_Email_Activation']);
Route::get('/email-recover-password', [RecoverPasswordController::class, 'index'])->name('email-recover-password');

//Articles
Route::get('/post', [PostsController::class, 'index'])->name('posts.index');




// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/users', [AuthController::class, 'getAuthUser']); //good
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    //Articles
    //Route::get('/post', [PostsController::class, 'index'])->name('posts.index');

    //Articles
    Route::get('/note', [NoteController::class, 'index'])->name('posts.index');
    Route::get('/note/show', [NoteController::class, 'show'])->name('posts.show');
    Route::post('/note/store', [NoteController::class, 'store'])->name('posts.store'); //good
    Route::put('note/id', [NoteController::class, 'update'])->name('posts.update'); //good
    Route::delete('note/id', [NoteController::class, 'destroy'])->name('posts.delete');

});

