<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\CriteriosEvaluacion;
use App\Models\Docente;

class CriteriosevaluacionController extends Controller
{
    public function __construct()
   {
    $this->middleware('auth');
   }

    public function index()
   {
    $idpersona= Auth::user()->idpersona;
    $idusuario= Auth::user()->id;
    $tipodocente=Docente::where('id',$idpersona)->get();
    foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
    }
    $datoscriterio= CriteriosEvaluacion::all()->where('id_usuario',$idusuario);
    return view('Criterios/index',compact('datoscriterio','tipodoc'));
   }
}
