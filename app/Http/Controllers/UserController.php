<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->rassword)
        ]);
        session()->flash('success', 'Регистрация пройдена');
        /**
         * авторизация
         */
        \Illuminate\Support\Facades\Auth::login($user);
        return redirect()->home();
    }

}
