<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;



class ProfileController extends Controller
{
    // Recuperar la información del perfil aquí
    public function showProfile()
    {
        $user = Auth::user();
        if (Auth::check()){
            return view('perfil', ['user' => $user]);
        }else{
            abort(403, 'Registrate para acceder a esta pagina!');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->user()->id,
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'image' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();

        if ($request->password !== $request->password_confirmation) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('password', 'Passwords do not match');
            return redirect()->back()->withErrors($errors)->withInput();
        }

        $path = ''; 
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->hashName();
            $path = $image->store('public');
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $path;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Perfil actualizado correctamente.');
    }

}
