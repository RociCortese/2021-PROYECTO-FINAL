<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Familia;
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

class CargaFamiliaController extends Controller
{
	public function index(Request $request)
    {

    	$familias = Familia::all();
        //$nombre = $request->get('buscarnombre');
        //$apellido = $request->get('buscarapellido');
        $familias = Familia::nombres($nombre)->apellidos($apellido)->simplePaginate(5);
        return view('admin.familia.index', compact('familias')); 
    }

    public function create()
    {
        $familias = Familia::all();
        return view('admin.docentes.create', compact('docentes'));
    }

    public function store(Request $request)
    {
         $request->validate([
            'dni' => ['required', 'int','digits_between:7,8','unique:docentes'],
            'nombre' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellido' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'genero' => ['required'],
            'telefono' => ['required','int','digits:value'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:docentes'],
            'vinculofamiliar' => ['required'],
          
        ]);
    
        Familia::create($request->all());
     
        return redirect()->route('familias.index')
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
