<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $article_id)
    {
        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user_id = Auth::user()->id;
        $comment->article_id = $article_id;
        $comment->save();

        return redirect()->back();
    }

}
