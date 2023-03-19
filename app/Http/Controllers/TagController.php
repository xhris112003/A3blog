<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;

class TagController extends Controller
{
    public function addTag(Request $request)
    {
        $article = Article::findOrFail($request->article_id);
        $tagName = $request->newTag;

        $tag = Tag::firstOrCreate(['name' => $tagName]);
        $article->tags()->attach($tag);

        return redirect()->back()->with('success', 'Tag agregado correctamente.');
    }

    public function searchByTag(Request $request)
    {
        $query = $request->input('query');
        $articles = Article::whereHas('tags', function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->input('query') . '%');
        })->with('tags')->get();

        return response()->json($articles);
    }




}