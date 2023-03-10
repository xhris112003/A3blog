<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function index()
    {
        $articles = Article::all();
        $user = Auth::user();

        $articles = Article::with('user')->get();
        $comments = Comment::with('user')->get();

        return view('articles.index', compact('articles', 'user', 'comments'));
    }

    public function create()
    {
        return view('articles.create');
    }
    public function show($id)
    {
        $article = Article::find($id);
        $comments = Comment::where('article_id', $id)->with('user')->get();
        return view('articles.show', compact('article', 'comments'));
    }
    public function store(Request $request)
    {
        $userId = Auth::id();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('public');
        }
        $article = new Article();
        $article->user_id = $userId;
        $article->title = $request->input('title');
        $article->body = $request->input('body');
        $article->image = $path;
        $article->save();

        return redirect('/');
    }

    public function destroy(Article $article)
    {
        if (Auth::id() !== $article->user_id) {
            return redirect()->back()->with('error', 'No tienes permiso para borrar este artículo.');
        }

        $article->delete();

        return redirect('/');
    }



}