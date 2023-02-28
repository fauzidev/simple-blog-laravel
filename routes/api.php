<?php

use App\Http\Controllers\{ArticleCommentController, ArticleController, 
    AuthenticationController,
    TagController,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('me', [AuthenticationController::class, 'me']);
    Route::post('logout', [AuthenticationController::class, 'logout']);

    Route::prefix('tags')->group(function() {
        Route::post('store',[TagController::class, 'store']);
        Route::patch('update/{id}',[TagController::class, 'update']);
        Route::delete('delete/{id}',[TagController::class, 'destroy']);
    });

    Route::prefix('articles')->group(function() {
        Route::post('store', [ArticleController::class, 'store']);
        Route::patch('update/{id}', [ArticleController::class, 'update']);
        Route::delete('delete/{id}', [ArticleController::class, 'destroy']);
    });

    Route::prefix('article-comments')->group(function() {
        Route::post('{article_slug}/store', [ArticleCommentController::class, 'store']);
        Route::patch('{article_slug}/update/{id}', [ArticleCommentController::class, 'update']);
        // Route::patch('update/{id}', [ArticleController::class, 'update']);
        // Route::delete('delete/{id}', [ArticleController::class, 'destroy']);
    });
});

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);

Route::get('tags',[TagController::class, 'index']);
Route::get('articles', [ArticleController::class, 'index']);
Route::get('articles/show/{article_slug}', [ArticleController::class, 'show']);
