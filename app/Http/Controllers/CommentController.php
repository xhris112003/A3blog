<?php

namespace App\Http\Controllers;
use App\Models\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment;
        $comment->article_id = $request->article_id;
        $comment->body = $request->body;
        $comment->save();

        return redirect()->back();
    }

}
