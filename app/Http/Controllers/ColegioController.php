<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Colegio;
use DB;
use Input;

class ColegioController extends Controller
{
    public function __construct()
   {
    $this->middleware('auth');
   }

    public function index()
   {
    //$colegio = Colegio::all();
    $idusuario = Auth::user()->id;
    $colegio = Colegio::usuario($idusuario)->get();
    return view('Colegio/cargacolegio',compact('colegio'));
   }


public function store(Request $request)
{
   $request->validate([
  'file'=> ['required','image','max:2048','dimensions:min_width=128,min_height=128'],
  'nombre' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
  'telefono' => ['required','int'],
  'direccion' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
  'localidad' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
  'provincia' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
  'email' => ['required', 'string', 'email', 'max:255', 'unique:colegio'],
  'gestion' => ['required', 'string'],
        ]);

  $files=new File();
  $files->file=$request->file;
  if($request->hasfile("file")){
    $imagen=$request->file("file");
    $nombreimagen = Str::slug($request->file).".".$imagen->guessExtension();
    $ruta=public_path("file");
    $imagen->move($ruta,$nombreimagen);
    $files->file=$nombreimagen;
  }
  $files->save();

  $colegio=new Colegio();
  $colegio->nombre=$request->nombre;
  $colegio->telefono=$request->telefono;
  $colegio->direccion=$request->direccion;
  $colegio->localidad=$request->localidad;
  $colegio->provincia=$request->provincia;
  $colegio->email=$request->email;
  $colegio->gestion=$request->gestion;
  $colegio->users_id=Auth::user()->id;
  $colegio->files_id=$files->id;
  $colegio->save();

  return redirect()->route('formulario')->with('success', 'El colegio se cargó correctamente');

}

public function edit(Colegio $id)
    {
      //$col = Colegio::findOrFail($id);
      return view('Colegio/editar', compact('id'));
    }

public function update(Request $request,$id)
    {
        $col = Colegio::findOrFail($id);
        $files=new File();
        $files->file=$request->file;
        if($request->hasfile("file")){
        $imagen=$request->file("file");
        $nombreimagen = Str::slug($request->file).".".$imagen->guessExtension();
        $ruta=public_path("file");
        $imagen->move($ruta,$nombreimagen);
        $files->file=$nombreimagen;
         $files->save();
        $col->files_id=$files->id;
        }
        $data= $request->only('nombre', 'gestion','direccion','telefono','localidad','provincia','email','file');
        $col->update($data);
        return redirect()->route('formulario');
    }
}

