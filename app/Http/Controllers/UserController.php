<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\administration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->rol_id = $request->rol_id;   

        if ($request->password !== $request->password_confirmation) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('password', 'Passwords do not match');
            return redirect()->back()->withErrors($errors)->withInput();
        }

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return response()->json(['success' => 'User updated successfully']);
    }

    public function destroy(User $users)
    {
        $users->delete();

        return redirect('/administration');
    }
}