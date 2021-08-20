<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Collaborator;
use App\Rules\inputSelect;
use Illuminate\Support\Facades\DB;


class CollaboratorController extends Controller
{

    public function index(Request $request){
        $search = trim($request->get('texto'));
        $colaboradores = DB::table('collaborators')
                        ->join('companies','collaborators.company_id', '=' , 'companies.id')
                        ->select('collaborators.*', 'companies.name AS collaborators')
                        ->where('collaborators.name','LIKE','%'.$search.'%')
                        ->orwhere('collaborators.last_name','LIKE','%'.$search.'%')
                        ->orWhere('collaborators.email','LIKE','%'.$search.'%')
                        ->orderBy('collaborators.id','asc')
                        ->paginate(10);
        $empresas = Company::all(); 
        return view('collaborators.collaborators_index', compact('search', 'colaboradores','empresas'));
    }

    public function store(Request $request){ 
        $request->validate([
            'name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'company_id' => ['required', new inputSelect()],
            'email' => 'nullable|email|max:50',
            'phone' => 'nullable|numeric'
        ]);

        $colaborador = new Collaborator;
        $colaborador->name = $request->name;
        $colaborador->last_name = $request->last_name;
        $colaborador->company_id = $request->company_id;
        $colaborador->email = $request->email;
        $colaborador->phone = $request->phone;

        if ($colaborador->save()) {
            return back()->with('message','Colaborador agregado exitosamente.')->with('typealert','success');
        }else{
            return back()->with('message','Ocurrió un problema al agregar el colaborador')->with('typealert','danger');
        }
    }

    public function edit(Request $request, $id){
        $search = trim($request->get('texto'));
        // fachade db
        $colaboradores = DB::table('collaborators')
                        ->join('companies','collaborators.company_id', '=' , 'companies.id')
                        ->select('collaborators.*', 'companies.name AS collaborators')
                        ->where('collaborators.name','LIKE','%'.$search.'%')
                        ->orWhere('collaborators.last_name','LIKE','%'.$search.'%')
                        ->orderBy('collaborators.id','asc')
                        ->paginate(10);

        $colaborador = Collaborator::findorFail($id);

        $empresas = Company::all();
        
        return view('collaborators.collaborators_edit', compact('search','colaboradores','colaborador','empresas'));
    }

    public function update($id, Request $request){
        $request->validate([
            'name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'company_id' => ['required', new inputSelect()],
            'email' => 'nullable|email|max:50',
            'phone' => 'nullable|numeric'
        ]);

        $colaborador = Collaborator::find($id);
        $colaborador->name = $request->name;
        $colaborador->last_name = $request->last_name;
        $colaborador->company_id = $request->company_id;
        $colaborador->email = $request->email;
        $colaborador->phone = $request->phone;

        if ($colaborador->save()) {
            return back()->with('message','Colaborador modificado exitosamente.')->with('typealert','success');
        }else{
            return back()->with('message','Ocurrió un problema al modificar el colaborador')->with('typealert','danger');
        }
    }

    public function delete($id){
        $delete = Collaborator::destroy($id);
        
        if ($delete) {
            return redirect()->route('colaboradores.show')->with('message','Colaborador eliminado exitosamente.')->with('typealert','success');
        }else{
            return redirect()->route('colaboradores.show')->with('message','Ocurrió un problema al eliminar el colaborador')->with('typealert','danger');
        }
    }
} 
