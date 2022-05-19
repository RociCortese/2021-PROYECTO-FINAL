<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use ZipArchive;
use App\Models\Año;
use App\Models\Docente;
use App\Models\Colegio;
use App\Models\Grado;
use App\Models\Alumno;

class LibretasController extends Controller
{
    public function buscador()
    {
    $idcolegio=Auth::user()->colegio_id;
    $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
     foreach($infoaño as $activo){
      $idaño="$activo->id";
      $descripcionaño="$activo->descripcion";
    }
    $nombresgrado=Grado::where('colegio_id',$idcolegio)->where('id_anio',$idaño)->pluck('descripcion');
    $infoperiodo=Colegio::where('id',$idcolegio)->get();
    foreach($infoperiodo as $infoperi){
      $informacionperiodo="$infoperi->periodo";
    }
    return view('libretas.buscador',compact('infoaño','nombresgrado','informacionperiodo')); 
    }

    public function index(Request $request)
    {
    $grado=$request->grado;
    $periodo=$request->periodo;
    $idcolegio=Auth::user()->colegio_id;
    $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
    foreach($infoaño as $activo){
      $idaño="$activo->id";
      $descripcionaño="$activo->descripcion";
    }
    $nombresgrado=Grado::where('colegio_id',$idcolegio)->where('id_anio',$idaño)->pluck('descripcion');
    $infoperiodo=Colegio::where('id',$idcolegio)->get();
    foreach($infoperiodo as $infoperi){
      $informacionperiodo="$infoperi->periodo";
    }
    $infogrado=Grado::where('colegio_id',$idcolegio)->where('id_anio',$idaño)->where('descripcion',$grado)->pluck('id_alumnos');
    $infogrado = preg_replace('/[\[\]\.\;\" "]+/', '', $infogrado);
    $infogrado=explode(',',$infogrado);
    $contador=count($infogrado)-1;
    for ($i=0; $i <=$contador ; $i++) { 
        $nombrealumno[]=Alumno::where('id',$infogrado[$i])->pluck('nombrealumno');
        $apellidoalumno[]=Alumno::where('id',$infogrado[$i])->pluck('apellidoalumno');
    }
    $nombrealumno = preg_replace('/[\[\]\.\;\" "]+/', '', $nombrealumno);
    $apellidoalumno = preg_replace('/[\[\]\.\;\" "]+/', '', $apellidoalumno);
    return view('libretas.listadoalumnos',compact('infoaño','informacionperiodo','nombrealumno','nombresgrado','apellidoalumno','grado','periodo'));
    }
    public function generarlibreta($nombrecompleto)
    {
    $pdf = \PDF::loadView('libretas.pdf', compact('nombrecompleto'));
    return $pdf->download('LibretaEscolar'.'-'.$nombrecompleto.'.pdf');
    }
    public function compartirinforme($nombrecompleto){
    $pdf = \PDF::loadView('libretas.pdf', compact('nombrecompleto'));
    Mail::send('libretas.pdf', $messageData, function ($mail) use ($pdf) {
    $mail->from('sofibovo501@gmail.com', 'John Doe');
    $mail->to('sofibovo501@gmail.com');
    $mail->attachData($pdf->output(), 'libretas.pdf');
});
    }
    /*    
    public function generartodosinformes(){ 
    $pdf = \PDF::loadView('libretas.pdf');
    $zip = new ZipArchive();
    $zip->add_file($pdf)
    $zip = "Informes.zip";
    return response()->download(public_path($zip));
    }*/
}