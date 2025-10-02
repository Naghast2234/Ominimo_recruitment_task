<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('/posts')->group(function () {
    Route::get('', function(Request $request) {
        return PostsController::getAllPosts($request);
    });
    Route::get('/create', function(Request $request) {
        return ; // I'll have to somehow pass a view here... Will figure it out tomorrow, it's kinda late for now.
    });
    Route::post('', function(Request $request) {
        return PostsController::makePost($request); // TODO: Make sure that the request contains post's title and content!
    });
    Route::get('/{post_id}', function(Request $request, int $post_id) { // View a single post with comments to it
        
    });

    Route::get('/{post_id}/edit', function(Request $request, int $post_id) { // Get the post for editing purposes.
        
    });

    Route::put('/{post_id}', function(Request $request, int $post_id) { // Update a post with new data
        
    });

    Route::delete('/{post_id}', function(Request $request, int $post_id) { // Delete a post
        
    });

    Route::post('/{post_id}/comments', function(Request $request, int $post_id) { // Add a post
        
    });
    
});

Route::get('/comments/{comment_id}', function(Request $request, int $comment_id) {
        
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
