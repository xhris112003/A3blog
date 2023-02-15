<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;



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
}
