<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        // So apparently here is where we also define gates. I should move my validations from the controllers to here.

        // Post-related gates
        Gate::define('edit-post', function(User $user, Post $post) { // Grab a post's details for editing
            return $user->id == $post->user_id;
        });

        Gate::define('update-post', function(User $user, Post $post) { // Update the post with edited data
            return $user->id == $post->user_id;
        });

        Gate::define('delete-post', function(User $user, Post $post) { // Delete a post
            return $user->id == $post->user_id;
        });

        // Comment-related gates
        //Creating a comment should be doable by anyone, even anonymous, apparently???

        Gate::define('delete-comment', function(User $user, Comment $comment) { // Delete a comment
            return ($user->id == $comment->user_id) || ($user->id == $comment->post->user_id); // Doable by both the comment's owner OR the post's owner. Post owners can censor comments yay! :D
        });

    }
}
