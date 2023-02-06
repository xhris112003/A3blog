<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('public');
        }
        $article = new Article();
        $article->title = $request->input('title');
        $article->body = $request->input('body');
        $article->image = $path;
        $article->save();
    
        return redirect('/');
    }


}
