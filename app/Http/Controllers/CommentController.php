<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $post_id)
    {
        $comment = new Comment();
        $comment->body = $request->input('body');
        $comment->post_id = $post_id;
        $comment->save();

        return redirect()->route('posts.show', $post_id);
    }

}
