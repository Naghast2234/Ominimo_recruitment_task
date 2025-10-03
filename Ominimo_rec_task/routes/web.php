<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;
use App\Http\Middleware\IsLoggedIn;
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
    Route::get('', function(Request $request) { //Grab all posts
        return PostsController::getAllPosts($request);
    });
    Route::get('/create', function(Request $request) { // Supposed to show a form to create a new post.
        return view('postForm');
    })->middleware(IsLoggedIn::class);
    Route::post('', function(Request $request) { // Create a new post
        return PostsController::makePost($request); 
    })->middleware(IsLoggedIn::class);
    Route::get('/{post_id}', function(Request $request, int $post_id) { // View a single post with comments to it
        return PostsController::getPostAndComments($request, $post_id);
    });

    Route::get('/{post_id}/edit', function(Request $request, int $post_id) { // Get the post for editing purposes.
        return PostsController::getPostForEdit($request, $post_id);
    })->middleware(IsLoggedIn::class);

    Route::put('/{post_id}', function(Request $request, int $post_id) { // Update a post with new data
        return PostsController::updatePost($request, $post_id);
    })->middleware(IsLoggedIn::class);

    Route::delete('/{post_id}', function(Request $request, int $post_id) { // Delete a post
        return PostsController::deletePost($request, $post_id);
    })->middleware(IsLoggedIn::class);

    Route::post('/{post_id}/comments', function(Request $request, int $post_id) { // Add a comment
        return CommentsController::createComment($request, $post_id);
    });
    
});

Route::delete('/comments/{comment_id}', function(Request $request, int $comment_id) { // Delete a comment
        return CommentsController::deleteComment($request, $comment_id);
})->middleware(IsLoggedIn::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
