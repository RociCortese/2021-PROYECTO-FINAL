<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Año;
use App\Models\Docente;
use App\Models\Colegio;
use App\Models\Grado;
use App\Models\Asistencia;

class AsistenciaController extends Controller
{
    public function index()
    {
    $idpersona= Auth::user()->idpersona;
    $tipodocente=Docente::where('id',$idpersona)->get();
    foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
    }
    $idcolegio=Auth::user()->colegio_id;
    $infoperiodo=Colegio::where('id',$idcolegio)->get();
    foreach($infoperiodo as $infoperi){
      $informacionperiodo="$infoperi->periodo";
    }
     $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
     foreach($infoaño as $activo){
      $idaño="$activo->id";
      $descripcionaño="$activo->descripcion";
    }
    $meses = array('Marzo', 'Abril', 'Mayo', 'Junio',
       'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    if($tipodoc=='Grado'){
    $gradodocente=Grado::where('id_docentes',Auth::user()->idpersona)->where('colegio_id',$idcolegio)->where('id_anio',$idaño)->pluck('descripcion');
    $infoasistencia=Asistencia::where('docente',Auth::user()->idpersona)->where('colegio_id',$idcolegio)->where('grado',$gradodocente)->where('año_id',$idaño)->get();
    }
    if($tipodoc!='Grado'){
    $gradodocente='Primer grado A';
    $infoasistencia=Asistencia::where('colegio_id',$idcolegio)->where('grado',$gradodocente)->where('año_id',$idaño)->get();   
    }
    $infoasistencia=$infoasistencia->unique('nombrealumno');
    return view('asistencia.asistencia',compact('tipodoc','informacionperiodo','descripcionaño','infoaño','meses','infoasistencia'));  
    }


    public function create()
    {
    $idpersona= Auth::user()->idpersona;
    $tipodocente=Docente::where('id',$idpersona)->get();
    foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
    }
    $idcolegio=Auth::user()->colegio_id;
    $infoperiodo=Colegio::where('id',$idcolegio)->get();
    foreach($infoperiodo as $infoperi){
      $informacionperiodo="$infoperi->periodo";
    }
    $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
     foreach($infoaño as $activo){
      $idaño="$activo->id";
      $descripcionaño="$activo->descripcion";
    }
    if($tipodoc=='Grado'){
    $gradodocente=Grado::where('id_docentes',Auth::user()->idpersona)->where('colegio_id',$idcolegio)->where('id_anio',$idaño)->pluck('descripcion');
    $infoasistencia=Asistencia::where('docente',Auth::user()->idpersona)->where('colegio_id',$idcolegio)->where('grado',$gradodocente)->where('año_id',$idaño)->get();
    }
    if($tipodoc!='Grado'){
    $gradodocente='Primer grado A';
    $infoasistencia=Asistencia::where('colegio_id',$idcolegio)->where('grado',$gradodocente)->where('año_id',$idaño)->get(); 
    }
    $infoasistencia=$infoasistencia->unique('nombrealumno');
    return view('asistencia.create',compact('infoasistencia')); 
    }



    public function store(Request $request)
    {
    $idpersona= Auth::user()->idpersona;
    $tipodocente=Docente::where('id',$idpersona)->get();
    foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
    }
    $idcolegio=Auth::user()->colegio_id;
    $infoperiodo=Colegio::where('id',$idcolegio)->get();
    foreach($infoperiodo as $infoperi){
      $informacionperiodo="$infoperi->periodo";
    }
    $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
     foreach($infoaño as $activo){
      $idaño="$activo->id";
      $descripcionaño="$activo->descripcion";
    }
    $meses = array('Marzo', 'Abril', 'Mayo', 'Junio',
       'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    if($tipodoc=='Grado'){
    $gradodocente=Grado::where('id_docentes',Auth::user()->idpersona)->where('colegio_id',$idcolegio)->where('id_anio',$idaño)->pluck('descripcion');
    $infoasistencia=Asistencia::where('docente',Auth::user()->idpersona)->where('colegio_id',$idcolegio)->where('grado',$gradodocente)->where('año_id',$idaño)->get();
    }
    if($tipodoc!='Grado'){
    $gradodocente='Primer grado A';
    $infoasistencia=Asistencia::where('colegio_id',$idcolegio)->where('grado',$gradodocente)->where('año_id',$idaño)->get(); 
    }
    $infoasistencia=$infoasistencia->unique('nombrealumno');
    $gradodocente=preg_replace('/[\[\]\.\;\""]+/', '', $gradodocente);
    $contadorasist=count($infoasistencia)-1;
    for ($i=0; $i <=$contadorasist ; $i++) { 
        if($infoasistencia[$i]->fecha==null){
         $request->validate([
            'diaasistencia' => ['required'],
        ]);
        $infoasistencia[$i]->fecha=$request->diaasistencia;
        $infoasistencia[$i]->estado='Ausente';  
        $presentes=$request->estadoasistencia;
        if(empty($presentes)){
        }
        else{
        $contadorpresentes=count($presentes)-1;
        for ($j=0; $j <=$contadorpresentes; $j++) { 
            if($presentes[$j]==$infoasistencia[$i]->id_alumno){
            $infoasistencia[$i]->estado='Presente';
            break;
            }
        }
        }
        $infoasistencia[$i]->tardanza=0;  
        $tardanzas=$request->tardanza;
        if(empty($tardanzas)){
        }
        else{
        $contadortardanzas=count($tardanzas)-1;
        for ($j=0; $j <=$contadortardanzas; $j++) { 
            if($tardanzas[$j]==$infoasistencia[$i]->id_alumno){
            $infoasistencia[$i]->tardanza=1; 
            break;
            }
        }
        }
        $infoasistencia[$i]->update();
        }
        else{
        $request->validate([
            'diaasistencia' => ['required'],
        ]);
        $asistencia=new Asistencia();
        $asistencia->id_alumno=$infoasistencia[$i]->id_alumno;
        $asistencia->nombrealumno=$infoasistencia[$i]->nombrealumno;
        $asistencia->fecha=$request->diaasistencia;
        $asistencia->estado='Ausente';  
        $presentes=$request->estadoasistencia;
        if(empty($presentes)){
        }
        else{
        $contadorpresentes=count($presentes)-1;
        
        for ($j=0; $j <=$contadorpresentes; $j++) { 
            if($presentes[$j]==$infoasistencia[$i]->id_alumno){
            $asistencia->estado='Presente';
            break;
            }
        }
        }
        $asistencia->tardanza=0;  
        $tardanzas=$request->tardanza;
        if(empty($tardanzas)){
        }
        else{
        $contadortardanzas=count($tardanzas)-1;
        for ($j=0; $j <=$contadortardanzas; $j++) { 
            if($tardanzas[$j]==$infoasistencia[$i]->id_alumno){
            $asistencia->tardanza=1; 
            break;
            }
        }
        }
        $asistencia->docente=Auth::user()->idpersona;
        $asistencia->grado=$gradodocente;
        $asistencia->colegio_id=$idcolegio;
        $asistencia->año_id=$idaño;
        $asistencia->save();
        }
    }
    return view('asistencia.asistencia',compact('tipodoc','informacionperiodo','descripcionaño','infoaño','meses','infoasistencia')); 
    }

    public function buscador()
    {

    $idpersona= Auth::user()->idpersona;
    $tipodocente=Docente::where('id',$idpersona)->get();
    foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
    }
    $idcolegio=Auth::user()->colegio_id;
    $infoperiodo=Colegio::where('id',$idcolegio)->get();
    foreach($infoperiodo as $infoperi){
      $informacionperiodo="$infoperi->periodo";
    }
    $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
     foreach($infoaño as $activo){
      $idaño="$activo->id";
      $descripcionaño="$activo->descripcion";
    }
    
    if($tipodoc=='Grado'){
    $gradodocente=Grado::where('id_docentes',Auth::user()->idpersona)->where('colegio_id',$idcolegio)->where('id_anio',$idaño)->pluck('descripcion');
    $infoasistencia=Asistencia::where('docente',Auth::user()->idpersona)->where('colegio_id',$idcolegio)->where('grado',$gradodocente)->where('año_id',$idaño)->get();
     


    }
    return view('asistencia.buscadorfecha',compact('tipodoc','informacionperiodo','descripcionaño','infoaño','infoasistencia')); 
    }

    
    public function editarasistencia()
    {
    $idpersona= Auth::user()->idpersona;
    $tipodocente=Docente::where('id',$idpersona)->get();
    foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
    }
    $idcolegio=Auth::user()->colegio_id;
    $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
     foreach($infoaño as $activo){
      $idaño="$activo->id";
      $descripcionaño="$activo->descripcion";
    }

    if($tipodoc=='Grado'){
    $gradodocente=Grado::where('id_docentes',Auth::user()->idpersona)->where('colegio_id',$idcolegio)->where('id_anio',$idaño)->pluck('descripcion');
    $infoasistencia=Asistencia::where('docente',Auth::user()->idpersona)->where('colegio_id',$idcolegio)->where('grado',$gradodocente)->where('año_id',$idaño)->get();
    }
    if($tipodoc!='Grado'){
    $gradodocente='Primer grado A';
    $infoasistencia=Asistencia::where('colegio_id',$idcolegio)->where('grado',$gradodocente)->where('año_id',$idaño)->get();   
    }


    return view('asistencia.editarasistencia',compact('infoasistencia')); 
    }

    public function update(Request $request)
    {
    $idpersona= Auth::user()->idpersona;
    $tipodocente=Docente::where('id',$idpersona)->get();
    foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
    }
    $idcolegio=Auth::user()->colegio_id;
    $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
     foreach($infoaño as $activo){
      $idaño="$activo->id";
      $descripcionaño="$activo->descripcion";
    }
        
    if($tipodoc=='Grado'){
    $gradodocente=Grado::where('id_docentes',Auth::user()->idpersona)->where('colegio_id',$idcolegio)->where('id_anio',$idaño)->pluck('descripcion');
    $infoasistencia=Asistencia::where('docente',Auth::user()->idpersona)->where('colegio_id',$idcolegio)->where('grado',$gradodocente)->where('año_id',$idaño)->first();
    }
    if($tipodoc!='Grado'){
    $gradodocente='Primer grado A';
    $infoasistencia=Asistencia::where('colegio_id',$idcolegio)->where('grado',$gradodocente)->where('año_id',$idaño)->get();   
    }

    $infoasistencia->fecha=$request->diaasistencia;
    $infoasistencia->update();

return view('asistencia.editarasistencia',compact('infoasistencia')); 
    
    }
    
}