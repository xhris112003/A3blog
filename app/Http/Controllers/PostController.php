<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($image)->resize(800, 400)->save($location);
            $post->image = $filename;
        }

        $post->save();

        return redirect()->route('posts.index');
}

}
