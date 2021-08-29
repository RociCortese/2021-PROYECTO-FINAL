<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use User;

class StorageController extends Controller
{
    public function __construct()
   {
    $this->middleware('auth');
   }

    public function index()
   {
    return view('Archivos/cargaarchivo');
   }

public function store(Request $request)
{
  /*Validación tipo de imagen*/
  $request ->validate([
    'file'=>'required|image|max:2048|dimensions:min_width=128px,min_height=128px'
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
  return $files->file;
  /*$users = Auth::user(); 
  $users->files()->attach($files->idfiles);
  $users->save();*/
  /*
  $users->idfiles=$files->id;
  $users->save();*/
  
}
}
