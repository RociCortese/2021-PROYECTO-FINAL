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
use App\Models\Informes;
use Mail;

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
    $infogrado=Informes::where('colegio_id',$idcolegio)->where('año',$idaño)->where('grado',$grado)->where('periodo',$periodo)->pluck('id_alumno');
    $infogrado = preg_replace('/[\[\]\.\;\""]+/', '', $infogrado);
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
    public function generarlibreta(Request $request, $nombrecompleto)
    {
    $periodo=$request->periodo;
    $pdf = \PDF::loadView('libretas.pdf', compact('nombrecompleto','periodo'));
    return $pdf->download('InformeEscolar'.'-'.$nombrecompleto.'.pdf');
    }

    /*public function compartirinforme(Request $request, $nombrecompleto){
    $periodo=$request->periodo;
    $pdf = \PDF::loadView('libretas.pdf', compact('nombrecompleto','periodo'));
    Mail::send('emails/templates/send-invoice', $messageData, function ($mail) use ($pdf) {
    $mail->from('sofibovo501@gmail.com', 'John Doe');
    $mail->to('sofibovo501@gmail.com');
    $mail->attachData($pdf->output(), 'libretas.pdf');
    });
    }*/

    public function generartodosinformes(Request $request){ 
    $grado=$request->grado;
    $periodo=$request->periodo;
    $idcolegio=Auth::user()->colegio_id;
    $nombre=Alumno::where('grado',$grado)->where('colegio_id',$idcolegio)->pluck('nombrecompleto');
    $nombre = preg_replace('/[\[\]\.\;\""]+/', '', $nombre);
    $nombre=explode(',',$nombre);
    $contadoralumnos=count($nombre)-1;
    $zipfile = new ZipArchive();
    $zipfile->open(storage_path('app/public/archivos/Informes'.'-'.$grado.'.zip'), ZipArchive::CREATE);
    for ($i=0; $i <=$contadoralumnos ; $i++) { 
    $nombrecompleto=$nombre[$i];
    $pdf = \PDF::loadView('libretas.pdf', compact('nombrecompleto','periodo'))
        ->save(storage_path('app/public/archivos/') . 'InformeEscolar'.'-'.$nombrecompleto.'.pdf');
    $zipfile->addFile(storage_path('app/public/archivos/InformeEscolar'.'-'.$nombrecompleto.'.pdf'), 'InformeEscolar'.'-'.$nombrecompleto.'.pdf');
    }
    $zipfile->close();
    return response()->download(storage_path('app/public/archivos/Informes'.'-'.$grado.'.zip'));
}
}