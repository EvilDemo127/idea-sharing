<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoginCheck;
use App\Models\QuestionComment;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile/edit', [PageController::class, 'profilEdit'])->name('profile.edit');
    Route::post('/profile/update', [PageController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/profile/question', [QuestionController::class, 'question_owner'])->name('question.own');

    Route::get('/', [QuestionController::class, 'home'])->name('home');
    Route::get('/question/details/{slug}', [QuestionController::class, 'details'])->name('question.details');
    Route::post('/question/like/{id}', [QuestionController::class, 'like_handle'])->name('like.handle');
    Route::post('/question/comment/create/{id}', [QuestionController::class, 'comment_create'])->name('comment.create');

    Route::get('/question/create', [QuestionController::class, 'create_question'])->name('question.create');
    Route::post('/question/store', [QuestionController::class, 'store_question'])->name('question.store');
    Route::post('/question/delete/{id}', [QuestionController::class, 'delete_question'])->name('question.delete');
    Route::get('/question/filter/{slug}', [QuestionController::class, 'filter_question'])->name('question.filter');
    Route::get('/question/searching/{search}', [QuestionController::class, 'search_question'])->name('question.search');
     Route::post('/comment/edit/{id}', [QuestionController::class, 'edit_comment'])->name('comment.edit');
     Route::post('/comment/delete/{id}', [QuestionController::class, 'delete_comment'])->name('comment.delete');
});

Route::group(['middleware' => 'LoginCheck'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/loginUser', [AuthController::class, 'loginUser'])->name('loginUser');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerUser']);
});
