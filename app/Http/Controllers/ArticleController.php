<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
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


        $articles = Article::with(['user', 'tags'])->get();
        $comments = Comment::with('user')->get();

        return view('articles.index', compact('articles', 'user', 'comments'));
    }
    public function myarticles()
    {
        $articles = Article::all();
        $user = Auth::user();

        $articles = Article::with('user')->get();
        $comments = Comment::with('user')->get();

        return view('articles.myarticles', compact('articles', 'user', 'comments'));
    }

    public function create()
    {
        return view('articles.create');
    }
    public function show($id)
    {
        $user = Auth::user();
        $articles = Article::findOrFail($id);
        $articles = Article::with('user')->get();
        $comments = Comment::with('user')->get();



        return view('articles.index', compact('articles', 'user', 'comments'));
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
        $user = Auth::user();
        if ($user->rol_id == 1 || Auth::id() === $article->user_id) {
            $article->delete();
            return redirect('/');
        }

        return redirect()->back()->with('error', 'No tienes permiso para borrar este artículo.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        $article->title = $request->title;
        $article->body = $request->body;

        $article->save();
        return response()->json(['success' => 'Article updated successfully']);
    }



}