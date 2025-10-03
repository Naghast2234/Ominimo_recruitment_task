<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class PostsController extends Controller {

    public static function makePost(Request $request) {
        $post = new Post();

        $title = $request->get('title');
        $content = $request->get('content');

        $post->user_id = Auth::id();
        $post->title = $title;
        $post->content = $content;

        $post->save();

        return response('Post created successfully', 200, ['data' => $post->id]);
    }

    public static function updatePost(Request $request, int $post_id) {
        $post = Post::findOrFail($post_id);

        $title = $request->get('title');
        $content = $request->get('content');

        // Validation: Is the editing user an owner of the post? TODO: Add an admin/moderator role, add a role check.
        if (! Gate::allows('update-post', $post)) {
            abort(401);
            // return response('Invalid permission: Current user is not the owner of this post', 401);
        }

        // Okay, we can continue from here.

        $post->title = $title;
        $post->content = $content;

        $post->save();

        return response('Post edited successfully', 200, ['data' => $post->id]);
    }

    public static function deletePost(Request $request, int $post_id) {
        $post = Post::findOrFail($post_id);

        // Validation: Is the deleting user an owner of the post? TODO: Add an admin/moderator role, add a role check.
        if (! Gate::allows('delete-post', $post)) {
            abort(401);
            // return response('Invalid permission: Current user is not the owner of this post', 401);
        }

        $post->delete();

        return response('Post deleted successfully');
    }

    public static function getPostForEdit(Request $request, int $post_id) { // This fetches a single post model, for purpose of editing it by the creator.
        $post = Post::findOrFail($post_id);

        // Validation: Is the deleting user an owner of the post? TODO: Add an admin/moderator role, add a role check.
        if (! Gate::allows('edit-post', $post)) {
            abort(401);
            // return response('Invalid permission: Current user is not the owner of this post', 401);
        }

        
        return view('postForm', ['data' => $post]); // So this returns the same view as post create, but passes a prop to it!
    }

    public static function getPostAndComments(Request $request, int $post_id) { // Fetch a post and it's comments, for authenticated users to see.
        $post = Post::findOrFail($post_id);
        // No gates here.

        $comments = $post->comments;

        // dd($post, $comments);

        return view('postAndComments', ['data' => ['post' => $post, 'comments' => $comments]]);
    }

    public static function getAllPosts(Request $request) {
        // I don't think any authorisation is required here...
        $posts = Post::get()->toArray();
        return view('allPosts', ['data' => $posts]);
        // return Inertia::render('AllPostsTest', ['data' => $posts]);
    }


}
