<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
// helper ramdon
use Illuminate\support\Str;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index(Request $request){
        $search = trim($request->texto);
        $empresas = DB::table('companies')
                    ->select('id','name','email','photo','web_site')
                    ->where('name','LIKE','%'.$search.'%')
                    ->orwhere('email','LIKE','%'.$search.'%')
                    ->orwhere('web_site','LIKE','%'.$search.'%')
                    ->orderBy('id','asc')
                    ->paginate(10);
        return view('companies.companies_index', compact('empresas','search')); 
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|min:5|max:50',
            'email' => 'nullable|email|max:50',
            'photo' => 'nullable|image',
            'web_site' => 'nullable|active_url|max:50'           
        ]);

        $empresa = new Company;
        $empresa->name = $request->name;
        $empresa->email = $request->email;
        $empresa->photo = $request->photo;
        $empresa->web_site = $request->web_site;

        if ($request->hasFile('photo')) {
            $nombre = Str::random(10) . $request->file('photo')->getClientOriginalName();
            $ruta = storage_path().'\app\public\logos/'.$nombre;
            Image::make($request->file('photo'))
                    ->resize(100,100)
                    ->save($ruta);
            $empresa['photo'] = 'public/logos/' . $nombre;
        };

        if ($empresa->save()) {
            return back()->with('message','Empresa agregada exitosamente.')->with('typealert','success');
        }else{
            return back()->with('message','Ocurrió un problema al agregar la empresa')->with('typealert','danger');
        }
    }

    public function edit(Request $request,$id){
        $search = trim($request->get('texto'));
        $empresas = DB::table('companies')
                    ->select('id','name','email','photo','web_site')
                    ->where('name','LIKE','%'.$search.'%')
                    ->orderBy('id','asc')
                    ->paginate(10);
        $empresa = Company::findorFail($id);
        
        return view('companies.companies_edit', compact('empresas','empresa','search'));
    }

    public function update($id, Request $request){
        $request->validate([
            'name' => 'required|min:5|max:50',
            'email' => 'nullable|email|max:50',
            'photo' => 'nullable|image',
            'web_site' => 'nullable|active_url|max:50'           
        ]);

        $empresa = Company::find($id);
        $empresa->name = $request->name;
        $empresa->email = $request->email;
        $empresa->photo = $request->photo;
        $empresa->web_site = $request->web_site;

        if ($request->hasFile('photo')) {
            $nombre = Str::random(10) . $request->file('photo')->getClientOriginalName();
            $ruta = storage_path().'\app\public\logos/'.$nombre;
            Image::make($request->file('photo'))
                ->resize(100,100)
                ->save($ruta);
            $empresa['photo'] = 'public/logos/' . $nombre;
        }

        if ($empresa->save()) {
            return back()->with('message','Empresa modificada exitosamente.')->with('typealert','success');
        }else{
            return back()->with('message','Ocurrió un problema al modificar la empresa')->with('typealert','danger');
        }
    }

    public function delete($id){
        $empresa = Company::findorFail($id);
        Storage::delete($empresa->photo);
        $delete = Company::destroy($id);
        
        if ($delete) {
            return redirect()->route('empresas.show')->with('message','Empresa eliminada exitosamente.')->with('typealert','success');
        }else{
            return redirect()->route('empresas.show')->with('message','Ocurrió un problema al eliminar la empresa')->with('typealert','danger');
        }
    }

    // para agregar la empresa desde el modal en colaboradores
    public function insertCompany(Request $request){
        $empresa = new Company;
        $empresa->name = $request->name;
        
        if ($empresa->save()) {
            $empresas = Company::all();
            echo "<option selected >***Seleccione una Empresa***</option>";
            foreach ($empresas as $row) {
                echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>";
            }
        }else{
            return back()->with('message','Ocurrió un problema al agregar la empresa')->with('typealert','danger');
        }
    }
}