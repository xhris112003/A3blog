<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\administration;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AdministrationController extends Controller
{
    public function showUsers(){

        $user = User::all();
        $users = Auth::user();
        if(Auth::check() && $users->rol_id == 1){
            return view('administration',compact('user'));
        }else{
            abort(403,'No eres administrador.');
        }
        

        
    }

    public function addAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        if ($request->password !== $request->password_confirmation) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('password', 'Passwords do not match');
            return redirect()->back()->withErrors($errors)->withInput();
        }
        
        $user = User::all();
        $users = new User();
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        if ($request->password) {
            $users->password = Hash::make($request->password);
        }
        
        $users->rol_id = 1;
        $users->save();
    
        return redirect('/administration');
    }

}
