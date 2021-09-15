<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
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

class CargaAlumnoController extends Controller
{
	public function index()
    {
    	$alumnos = Alumno::paginate(5);
        return view('admin.alumnos.index', compact('alumnos')); 
    }

    public function create()
    {
        $alumnos = Alumno::all();
        return view('admin.alumnos.create', compact('alumnos'));
    }

    public function store(Request $request)
    {
         $request->validate([
            'dni' => ['required', 'int', 'min:1000000','max:99999999','unique:users'],
            'nombre' => ['required','alpha','max:50'],
            'apellido' => ['required','alpha','max:50'],
            'fechanacimiento' => 'required',
            'genero' => ['required'],
            'grado' => ['required'],
           
        ]);
    
        Alumno::create($request->all());
     
        return redirect()->route('alumnos.index')
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
