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
	public function index(Request $request)
    {

    	//$docentes = Docente::all();
        if($request){
        $apellido = trim($request->get('buscarapellido'));
        $docentes = Docente::where('apellido','LIKE','%'.$apellido.'%')->Paginate(5);
        return view('admin.docentes.index', compact('apellido','docentes')); 
                    }

    }
    

    public function create()
    {
        $docentes = Docente::all();
        return view('admin.docentes.create', compact('docentes'));
    }

    public function store(Request $request)
    {
         $request->validate([
            'dni' => ['required', 'int','digits_between:7,8','unique:docentes'],
            'nombre' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellido' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'fechanacimiento' => 'required',
            'genero' => ['required'],
            'domicilio' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'localidad' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'provincia' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'estadocivil' => ['required'],
            'telefono' => ['required','int'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:docentes'],
            'legajo' => ['required','int'],
            'especialidad' => ['required','regex:/^[\pL\s\-]+$/u','max:25'],
        ]);
    
        Docente::create($request->all());
     
        return redirect()->route('docentes.index')->with('success', 'El docente se cargó correctamente.');
    } 

   public function show($id)
    {
      $doc=Docente::findOrFail($id);
      return view('admin.docentes.show', compact('doc'));
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
