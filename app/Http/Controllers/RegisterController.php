<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        return view('auth.register'); 
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|alpha_dash|min:10|max:50',
            'password2' => 'same:password|max:50'
        ]);
        
        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        
        if($user->save()){
            return redirect('/login')->with('message','Usuario creado exitosamente.')->with('typealert', 'success');
        }
        
    }
}
