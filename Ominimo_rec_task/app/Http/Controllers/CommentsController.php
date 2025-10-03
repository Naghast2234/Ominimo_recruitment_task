<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentsController extends Controller {
    public static function createComment(Request $request, int $post_id) {
        $content = $request->get('comment');

        $comment = new Comment();

        $comment->comment = $content;
        $comment->post_id = $post_id;
        $comment->user_id = Auth::id(); // It may be null. In this case, it'd be anonymous. I suppose that's why post owner needs to be able to remove anon comments.


        $comment->save();

        return response('Successfully created a comment');

    }

    public static function deleteComment(Request $request, int $comment_id) {
        $comment = Comment::findOrFail($comment_id);

        if (! Gate::allows('delete-comment', $comment)) {
            abort(401);
        }

        $comment->delete();

        return response('Successfully deleted a comment');
    }
}
