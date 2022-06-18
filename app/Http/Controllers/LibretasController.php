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
use App\Models\Familia;
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
        $idalumno[]=Alumno::where('id',$infogrado[$i])->pluck('id');

    }
    $nombrealumno = preg_replace('/[\[\]\.\;\" "]+/', '', $nombrealumno);
    $apellidoalumno = preg_replace('/[\[\]\.\;\" "]+/', '', $apellidoalumno);
    $idalumno = preg_replace('/[\[\]\.\;\" "]+/', '', $idalumno);
    return view('libretas.listadoalumnos',compact('infoaño','informacionperiodo','nombrealumno','nombresgrado','apellidoalumno','grado','periodo','idalumno'));
    }
    public function generarlibreta(Request $request, $nombrecompleto)
    {
    $periodo=$request->periodo;
    $pdf = \PDF::loadView('libretas.pdf', compact('nombrecompleto','periodo'));
    return $pdf->download('InformeEscolar'.'-'.$nombrecompleto.'.pdf');
    }

    public function compartirinforme(Request $request, $nombrecompleto){
    $periodo=$request->periodo;
    $idalumno=$request->idalumno;
    $nombrecompleto=$request->nombrecompleto;
    $nombrecolegio=$request->nombrecolegio;
    $direccioncolegio=$request->direccioncolegio;
    $localidadcolegio=$request->localidadcolegio;
    $provinciacolegio=$request->provinciacolegio;
    $telefonocolegio=$request->telefonocolegio;
    $emailcolegio=$request->emailcolegio;
    $gradoalumno=$request->gradoalumno;
    $descripcionaño=$request->descripcionaño;
    $idfamilia=Alumno::where('id',$idalumno)->pluck('familias_id');
    $idfamilia = preg_replace('/[\[\]\.\;\" "]+/', '', $idfamilia);
    $emailfamilia=Familia::where('id',$idfamilia)->pluck('email');
    $emailfamilia = preg_replace('/[\[\]\\;\" "]+/', '', $emailfamilia);
    $pdf = \PDF::loadView('libretas.pdf', compact('nombrecompleto','periodo'));
    Mail::send('emails/templates/send-invoice', $request->all(), function ($mail) use ($pdf,$nombrecompleto,$emailfamilia) {
    $mail->from('snotraeducacion@gmail.com','Snotra');
    $mail->to($emailfamilia);
    $mail->subject('Informe escolar de '. $nombrecompleto);
    $mail->attachData($pdf->output(), 'InformeEscolar'.'-'.$nombrecompleto.'.pdf');
    });
    return back()->with('success', 'El informe se ha compartido correctamente.');
    }

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