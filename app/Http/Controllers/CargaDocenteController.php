<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use Session;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemCreateRequest;
use App\Http\Requests\ItemUpdateRequest;
use Illuminate\Support\Facades\Validator;
use DB;
use Input;
use Storage;

class CargaDocenteController extends Controller
{
	public function index()
    {
    	$docentes = Docente::all();
        return view('admin.docentes.index', compact('docentes')); 
    }

    public function create()
    {
        $docentes = Docente::all();
        return view('admin.docentes.create', compact('docentes'));
    }

    public function store(Request $request)
    {
         $request->validate([
            'dni' => ['required', 'int', 'min:1000000','max:99999999','unique:users'],
            'nombre' => ['required','alpha','max:50'],
            'apellido' => ['required','alpha','max:50'],
            'fechanacimiento' => 'required',
            'genero' => ['required'],
            'domicilio' => ['required','alpha','max:50'],
            'localidad' => ['required','alpha','max:50'],
            'provincia' => ['required','alpha','max:50'],
            'estadocivil' => ['required'],
            'telefono' => ['required','int'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'legajo' => ['required','int','max:20'],
            'especialidad' => ['required','alpha','max:25'],
        ]);
    
        Docente::create($request->all());
     
        return redirect()->route('docentes.index')
                        ->with('success','Post created successfully.');
    } 
    /*
    public function edit(Alumnos $id)
    {
    	$alu = Alumnos::findOrFail($id);
         return view('admin.alumnos.editar', compact('alu'));
    }

      public function update(Alumnos $id)
    {
        $alu = Alumnos::findOrFail($id);
		$alu->update();
   
    	return redirect()->route('alumnos.index');
    }

    public function destroy(Alumnos $id)
    {
        $id->delete();

        return redirect()->route('alumnos.index')
            ->with('success', 'Project deleted successfully');
    }*/

}
