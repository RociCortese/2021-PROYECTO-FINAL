<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
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

class CargaAlumnoController extends Controller
{
	public function index(Request $request)
    {
        $nombre = $request->get('buscarnombre');
        $apellido = $request->get('buscarapellido');
        $alumnos = Alumno::nombres($nombre)->apellidos($apellido)->simplePaginate(5);
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
            'dnialumno' => ['required', 'int','digits_between:7,8','unique:alumnos'],
            'nombrealumno' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellidoalumno' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'fechanacimiento' => 'required',
            'generoalumno' => ['required'],
            'domicilio' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'localidad' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'provincia' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'dnifamilia' => ['required', 'int','digits_between:7,8','unique:familias'],
            'nombrefamilia' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellidofamilia' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'generofamilia' => ['required'],
            'telefono' => ['required'],
            'email' => ['required'],
            'vinculofamiliar' => ['required'],
        

        ]);

    
        $familia=new Familia();
        $familia->nombrefamilia=$request->nombrefamilia;
        $familia->apellidofamilia=$request->apellidofamilia;
        $familia->dnifamilia=$request->dnifamilia;
        $familia->generofamilia=$request->generofamilia;
        $familia->telefono=$request->telefono;
        $familia->email=$request->email;
        $familia->vinculofamiliar=$request->vinculofamiliar;
        $familia->save();

        $alumno=new Alumno();
        $alumno->nombrealumno=$request->nombrealumno;
        $alumno->apellidoalumno=$request->apellidoalumno;
        $alumno->dnialumno=$request->dnialumno;
        $alumno->generoalumno=$request->generoalumno;
        $alumno->fechanacimiento=$request->fechanacimiento;
        $alumno->domicilio=$request->domicilio;
        $alumno->localidad=$request->localidad;
        $alumno->provincia=$request->provincia;
        $alumno->familias_id=$familia->id;
        $alumno->save();
       
        
     
        return redirect()->route('alumnos.index')
                        ->with('success','Post created successfully.');
    } 

    public function show($id)
    {
        $alu=Alumno::findOrFail($id);
        $familia = Familia::findOrFail($id);
        return view('admin.alumnos.show',compact('alu','familia')); 
    }

   
}
