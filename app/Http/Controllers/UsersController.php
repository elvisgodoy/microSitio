<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller 
{
    public function index(Request $request){
        $search = trim($request->get('texto'));
        $usuarios = DB::table('users')
                    ->select('*')
                    ->where('name', 'LIKE', '%'.$search.'%')
                    ->orwhere('last_name', 'LIKE', '%'.$search.'%')
                    ->orwhere('email', 'LIKE', '%'.$search.'%')
                    ->orderBy('id','asc')
                    ->paginate(10);
        return view('users.users_index', compact('search','usuarios'));
    }
    
    public function updateRole(Request $request){
        $update = User::where('id', $request->id)
                    ->update(['role' => $request->role]);
        if($update){
            if ($request->role == 0) {
                $newRole = '<buttom type="buttom" style="width: 72px" class="btn btn-sm btn-danger">Inactivo</buttom>';
                $user = 'Usuario';
            }else{
                $newRole = '<buttom type="buttom" style="width: 72px" class="btn btn-sm btn-success">Activo</buttom>';
                $user = 'Administrador';
            }
        }
        return response()->json(['var'=>''.$newRole.'', 'user' =>''.$user.'']);
    }

    public function user_profile(){
        return view('users.user_profile');
    }

    public function updateUser($id, Request $request){
        $rules = [
            'name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'required|email|max:50',
            'photo' => 'nullable|image',
        ];

        $messages = [
            'name.required' => 'El campo Nombre es obligatorio.',
            'name.min' => 'El campo Nombre debe contener al menos 3 caracteres.',
            'name.max' => 'El campo Nombre no debe contener más de 50 caracteres.',
            'last_name.required' => 'El campo Apellido es obligatorio.',
            'lats_name.min' => 'El campo Apellido debe contener al menos 3 caracteres.',
            'lats_name.max' => 'El campo Apellido no debe contener más de 50 caracteres.',
            'email.required' => 'El campo Correo Electronico es obligatorio.',
            'email.email' => 'El campo Correo Electronico debe ser un correo valido.',
            'email.max' => 'El campo Correo Electronico no debe contener más de 50 caracteres.',
            'photo.image' => 'El campo Foto debe ser una imagen.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Por favor asegúrese de llenar los campos solicitados.')->with('typealert', 'danger')->withInput()->with('update','1');
        else:
            $usuario = request()->except('_token');

            if ($request->hasFile('photo')) {
                $nombre = Str::random(10) . $request->file('photo')->getClientOriginalName();
                $ruta = storage_path().'\app\public\photo/'.$nombre;
                Image::make($request->file('photo'))
                    ->resize(null, 100, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($ruta);

                $usuario['photo'] = 'public/photo/' . $nombre;
            }

            $save = User::where('id','=',$id)->update($usuario);

            if ($save) {
                return back()->with('message','Usuario modificado exitosamente.')->with('typealert','success');
            }else{
                return back()->with('message','Ocurrió un problema al cambiar los datos')->with('typealert','danger');
            }
        endif;
    }

    public function usersAdmin(Request $request){
        $search = trim($request->get('texto'));
        $usuarios = DB::table('users')
                    ->where('role', '=', 1)
                    ->paginate(10);
        return view('users.users_index', compact('search', 'usuarios')); 
    }
    public function users(Request $request){
        $search = trim($request->get('texto'));
        $usuarios = DB::table('users')
                    ->where('role', '=', 0)
                    ->paginate(10);
        return view('users.users_index', compact('search', 'usuarios'));
    }
}
