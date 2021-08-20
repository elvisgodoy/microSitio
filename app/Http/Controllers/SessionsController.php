<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function session(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email','password');

        if (Auth::attempt( $credentials )) { 
            if(Auth::user()->role == 1) {
                return redirect('/dashboard')->with('message', 'Bienvenido '. Auth::user()->name.' '. Auth::user()->last_name)->with('typealert', 'success');
            }else{
                return back()->with('message', 'El usuario no cuenta con los permisos de administrador')->with('typealert', 'danger');
            }
        }else{
            return back()->with('message', 'El correo o contraseña son incorrectos')->with('typealert', 'danger');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
