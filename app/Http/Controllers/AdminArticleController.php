<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;


class AdminArticleController extends Controller
{
    public function showArticle()
    {
        $article = Article::all();
        $users = Auth::user();
        if(Auth::check() && $users->rol_id == 1){
            return view('adminArticle', compact('article'));
        }else{
            abort(403,'No eres administrador.');
        }
        

        return view('AdminArticle');
    }
}
