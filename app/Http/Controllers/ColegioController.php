<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Colegio;
use Illuminate\Database\Eloquent\Relations\HasOne;
use DB;

class ColegioController extends Controller
{
    public function __construct()
   {
    $this->middleware('auth');
   }

    public function index()
   {
    return view('Colegio/cargacolegio');
   }

   protected function validator(array $data)
    {
        return Validator::make($data, [
            'file'=>'required|image|max:2048|dimensions:min_width=128,min_height=128'
        ]);

    }

public function store(array $data)
{
   return Colegio::create([
  'nombre' => $data['nombre'],
  'direccion' => $data['direccion'],
  'telefono' => $data['telefono'],
        ]);
 
  
  /*Carga de imagen a la base de datos*/
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

  $users = Auth::user(); 
  $users->file()->associate($files);
  $users->save();
  return redirect()->route('formulario');
  
}

public function delete(){
   $userfile = Auth::user()->file_id;
   File::destroy($userfile);
   return redirect()->route('formulario');       
}
}

