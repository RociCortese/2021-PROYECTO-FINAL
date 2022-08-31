<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Año;
use App\Models\Colegio;
use App\Models\Grado;
use App\Models\Alumno;
use App\Models\Asistencia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AsistenciaFamiliaController extends Controller
{
    public function buscador()
    {
    $idcolegio=Auth::user()->colegio_id;
    $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
     foreach($infoaño as $activo){
      $idaño="$activo->id";
      $descripcionaño="$activo->descripcion";
    }
    $idfamilia=Auth::user()->idpersona;
    $nombrealumno=Alumno::where('familias_id',$idfamilia)->pluck('nombrecompleto');
    $contadoralumnos=count($nombrealumno)-1;
    for($i=0;$i<=$contadoralumnos;$i++){
    $infoasistencia[]=Asistencia::where('nombrealumno',$nombrealumno[$i])->where('estado','Ausente')->orderby('justificacion','ASC')->orderby('fecha','ASC')->get(); 
    $nuevajustificacion[]=Asistencia::where('nombrealumno',$nombrealumno[$i])->where('estado','Ausente')->where('justificacion',0)->get();
    }

    return view('AsistenciaFamilia.buscador',compact('infoaño','infoasistencia'));
    }

    public function enviarjustificacion(Request $request,$id){
      $infoasistencia=Asistencia::where('id',$id)->first();
      $fechaasistencia=Asistencia::where('id',$id)->pluck('fecha');
      $fechaasistencia = preg_replace('/[\[\]\.\;\" "]+/', '', $fechaasistencia);
      $nombreasistencia=Asistencia::where('id',$id)->pluck('nombrealumno');
      $nombreasistencia = preg_replace('/[\[\]\.\;\" "]+/', '', $nombreasistencia);
      $infoasistencia->comentariojusti=$request->justificacion;
      $infoasistencia->archivojusti=$request->file;
      if($request->hasFile('file')){
      $imagen=$request->file("file");
      $nombreimagen = 'Justificacion'.'_'.$nombreasistencia.'_'.$fechaasistencia.".".$imagen->guessExtension();
      $ruta=storage_path("app/public/archivosjustificaciones");
      $imagen->move($ruta,$nombreimagen);
      $infoasistencia->archivojusti=$nombreimagen;
      }
      $infoasistencia->justificacion=1;
      $infoasistencia->fechajusti=date('Y-m-d');
      $infoasistencia->update();
      return redirect()->back()->with('success','La justificación se ha guardado correctamente.'); 
    }

    public function justificacioninasistencias()
    {
      $idcolegio=Auth::user()->colegio_id;
      $idpersona= Auth::user()->idpersona;
      $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
      foreach($infoaño as $activo){
      $idaño="$activo->id";
      $descripcionaño="$activo->descripcion";
      }
      $infoasistencia=Asistencia::where('docente',$idpersona)->where('colegio_id',$idcolegio)->where('año_id',$idaño)->where('justificacion',1)->orderby('fecha','DESC')->paginate(5);
      return view('AsistenciaFamilia.justificacion',compact('infoaño','infoasistencia')); 
    }

    public function aceptarjustificacion(Request $request, $id){
      $infoasistencia=Asistencia::where('id',$id)->first();
      $infoasistencia->gestionjustificacion=1;
      $infoasistencia->estado='Ausente justificada';
      $infoasistencia->update();
      return redirect()->back()->with('success','La justificación se ha gestionado correctamente.'); 
    }

    public function descargararchivo($id){
        $archivoasistencia=Asistencia::where('id',$id)->pluck('archivojusti');
        $archivoasistencia = preg_replace('/[\[\]\\;\" "]+/', '', $archivoasistencia);
        $file = storage_path('app/public/archivosjustificaciones/'.$archivoasistencia);
         return response()->download($file);
    }
}