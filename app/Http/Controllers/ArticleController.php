<?php

namespace App\Http\Controllers;
use App\Models\Article;
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
        
        $articles = Article::with('user')->get();

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }
    public function show($id)
    {
        $article = Article::find($id);
        $comments = $articles->comments;
        return view('articles.show', compact('articles', 'comments'));
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
