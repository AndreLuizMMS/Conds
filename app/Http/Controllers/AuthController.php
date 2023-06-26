<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    //

    function register(Request $req) {
        $incomingFileds = $req->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => ['required', 'min:4', 'confirmed'],
        ]);

        $newUser = User::create($incomingFileds);
        Auth::login($newUser);
        
        if (auth()->user()->isAdmin) {
            return redirect('/admin/home');
        }
        if (auth()->user()->isSindico) {
            return redirect('/sindico/home');
        }
    }

    function login(Request $req) {
        $credentials = $req->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (auth()->user()->isAdmin) {
                return redirect('/admin/home');
            }
            if (auth()->user()->isSindico) {
                return redirect('/sindico/home');
            }
            Auth::logout();
            return redirect('/')->with('msg', 'Somente síndicos e administradores pode acessar');
        }
    }

    function logout() {
        Auth::logout();
        return redirect('/');
    }
}
