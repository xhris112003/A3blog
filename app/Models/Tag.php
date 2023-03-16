<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function searchByTag(Request $request)
    {
        $query = $request->input('query');
        $articles = Article::whereHas('tags', function ($q) use ($query) {
            $q->where('name', 'like', "%$query%");
        })->get();
        return response()->json($articles);
    }
}