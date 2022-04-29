<?php

namespace App\Http\Controllers;
header('Content-type: text/html; charset=UTF-8');

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\CriteriosEvaluacion;
use App\Models\Docente;
use App\Models\Año;
use App\Models\Colegio;
use App\Models\espacioscurriculares;
use App\Models\Grado;
use App\Models\Alumno;
use App\Models\Notas;
use App\Models\Informes;

class CriteriosevaluacionController extends Controller
{
    public function __construct()
   {
    $this->middleware('auth');
   }

    public function index(Request $request)
   {
    $idpersona= Auth::user()->idpersona;
    $idusuario= Auth::user()->id;
    $especialidad = trim($request->get('buscarespecialidad'));
    $añoescolar = trim($request->get('buscarañoescolar'));
    $grado = trim($request->get('buscargrado'));
    $tipodocente=Docente::where('id',$idpersona)->get();
    foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
    }
    if($tipodoc=='Grado'){
    $datoscriterio= CriteriosEvaluacion::where('id_usuario',$idusuario)->especialidad($especialidad)->año($añoescolar)->orderby('id_espacio','ASC')->paginate(5);
    }
    if($tipodoc!='Grado'){
    $datoscriterio= CriteriosEvaluacion::where('id_usuario',$idusuario)->especialidad($especialidad)->año($añoescolar)->grado($grado)->orderby('id','ASC')->paginate(5);
    }
    return view('Criterios/index',compact('datoscriterio','tipodoc','especialidad','añoescolar','grado'));
   }
    
 public function create()
    {
        $idpersona= Auth::user()->idpersona;
        $tipodocente=Docente::where('id',$idpersona)->get();
        foreach($tipodocente as $tipo){
            $tipodoc="$tipo->especialidad";
        }
        $idcolegio=Auth::user()->colegio_id;
        $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
        $infocolegio=Colegio::where('id',$idcolegio)->get();
        foreach($infocolegio as $info){
            $infocol="$info->espacioscurriculares";
            $informacionperiodo="$info->periodo";
        }
        $valor='0';
        if($tipodoc=='Grado'){
        $infocol = preg_replace('/[\[\]\.\;\" "]+/', '', $infocol);
        $infocol=explode(',', $infocol);
        $contador=count($infocol)-1;
        for ($i=0; $i <= $contador ; $i++) { 
        $nombreespacios[]=espacioscurriculares::where('id',$infocol[$i])->pluck("nombre");
        }
        return view('Criterios.create',compact('tipodoc','infoaño','infocol','valor','nombreespacios','informacionperiodo'));
        }
        if($tipodoc!='Grado'){
        $infogrado=Grado::where('colegio_id',$idcolegio)->orderby('num_grado','ASC')->get();
        foreach($infogrado as $informaciongrado){
        $docentesespeciales="$informaciongrado->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$informaciongrado->descripcion";
            }
        }
        }
        return view('Criterios.create',compact('tipodoc','infoaño','nombresgrado','valor','informacionperiodo'));
        }
    }
   public function store(Request $request)
    {
        $idpersona= Auth::user()->idpersona;
        $idusuario= Auth::user()->id;
        $tipodocente=Docente::where('id',$idpersona)->get();
        foreach($tipodocente as $tipo){
            $tipodoc="$tipo->especialidad";
        }
        $idcolegio=Auth::user()->colegio_id;
        $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
        foreach($infoaño as $info){
        $descripcionaño="$info->descripcion";
        $idaño="$info->id";
        }
        $checkperiodo=$request->aplicaperiodo;
        $infocolegio=Colegio::where('id',$idcolegio)->get();
        foreach($infocolegio as $info){
            $infocol="$info->espacioscurriculares";
            $infoperiodo="$info->periodo";
        }
        $infocol = preg_replace('/[\[\]\.\;\" "]+/', '', $infocol);
        $infocol=explode(',', $infocol);
        $contadorinfocol=count($infocol)-1;
        /*Docente de grado*/
        if($tipodoc=='Grado'){
        $check3=$request->aplicaespacios;
        $nombreespaciocurri=$request->espaciocurricular;
        if(empty($check3)){
        if(empty($checkperiodo)){
        $request->validate([
        'criterio' => ['required','max:50'],
        'ponderacion' => ['required','int'],
        'descripcion' => ['max:150'],
        'espaciocurricular' => ['required'],
        ]);
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->periodo=$request->periodo;
        $nuevocriterio->id_espacio=$request->espaciocurricular;
        $nuevocriterio->save();
        $infogrado=Grado::where('id_docentes',Auth::user()->idpersona)->where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=Auth::user()->id;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->espacio=$nuevocriterio->id_espacio;
        $nota->save();
        $todosinformes=Informes::where('docente',Auth::user()->id)->where('periodo',$nuevocriterio->periodo)->where('espacio',$nuevocriterio->id_espacio)->where('colegio_id',$idcolegio)->where('año',$idaño)->get();
        $continformes=count($todosinformes);
        if($continformes==0){
            $informe=new Informes();
            $informe->observacion=$request->observacion;
            $informe->año=$idaño;
            $informe->colegio_id=$idcolegio;
            $informe->id_alumno=$idalumno;
            $informe->docente=Auth::user()->id;
            $informe->periodo=$nuevocriterio->periodo;
            $informe->espacio=$nuevocriterio->id_espacio;
            $informe->save();
        }
        else{
        $contadorinforme=count($todosinformes)-1;
            if($array[$i]!=$idalumno){
            $informe=new Informes();
            $informe->observacion=$request->observacion;
            $informe->año=$idaño;
            $informe->colegio_id=$idcolegio;
            $informe->id_alumno=$idalumno;
            $informe->docente=Auth::user()->id;
            $informe->periodo=$nuevocriterio->periodo;
            $informe->espacio=$nuevocriterio->id_espacio;
            $informe->save();
            }
        }
    } 
    }
    
        }
        else{
        $request->validate([
        'criterio' => ['required','max:50'],
        'ponderacion' => ['required','int'],
        'descripcion' => ['max:150'],
        'espaciocurricular' => ['required'],
        ]);
        if($infoperiodo=='Bimestre'){
        for($i=1;$i<=4;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_espacio=$request->espaciocurricular;
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        if($i==3){ 
        $nuevocriterio->periodo='Tercer período';
        }
        if($i==4){ 
        $nuevocriterio->periodo='Cuarto período';
        }
        $nuevocriterio->save();
        }
        }
        if($infoperiodo=='Trimestre'){
        for($i=1;$i<=3;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_espacio=$request->espaciocurricular; 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        if($i==3){ 
        $nuevocriterio->periodo='Tercer período';
        }
        $nuevocriterio->save();
        }
        }
        if($infoperiodo=='Cuatrimestre'){
        for($i=1;$i<=2;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_espacio=$request->espaciocurricular; 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        $nuevocriterio->save();
        }
        }
        if($infoperiodo=='Semestre'){
        for($i=1;$i<=2;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_espacio=$request->espaciocurricular; 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        $nuevocriterio->save();
        }
        }
        $infogrado=Grado::where('id_docentes',Auth::user()->idpersona)->where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=Auth::user()->id;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->espacio=$nuevocriterio->id_espacio;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=Auth::user()->id;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->espacio=$nuevocriterio->id_espacio;
        $informe->save();
    }
    }
        }
        }
        
        else{
        if(empty($checkperiodo)){
        $request->validate([
        'criterio' => ['required','max:50'],
        'ponderacion' => ['required','int'],
        'descripcion' => ['max:150'],
        ]);
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->periodo=$request->periodo;
        $nuevocriterio->id_espacio=$request->espaciocurricular;
        $nuevocriterio->save(); 
        $infogrado=Grado::where('id_docentes',Auth::user()->idpersona)->where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=Auth::user()->id;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->espacio=$nuevocriterio->id_espacio;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=Auth::user()->id;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->espacio=$nuevocriterio->id_espacio;
        $informe->save();
    }
    }
        }
        else{
        $request->validate([
        'criterio' => ['required','max:50'],
        'ponderacion' => ['required','int'],
        'descripcion' => ['max:150'],
        ]);
        if($infoperiodo=='Bimestre'){
        for($i=1;$i<=4;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nombreespacios=espacioscurriculares::where('id',$infocol[$i])->get();
        foreach($nombreespacios as $nombreesp){
        $nuevocriterio->id_espacio="$nombreesp->nombre";
        };
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        if($i==3){ 
        $nuevocriterio->periodo='Tercer período';
        }
        if($i==4){ 
        $nuevocriterio->periodo='Cuarto período';
        }
        $nuevocriterio->save();
        }
        }
        if($infoperiodo=='Trimestre'){
        for($i=1;$i<=3;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        for($j=0;$j<=$contadorinfocol;$j++){
        $nombreespacios=espacioscurriculares::where('id',$infocol[$j])->get();
        
        foreach($nombreespacios as $nombreesp){
        $nuevocriterio->id_espacio="$nombreesp->nombre";
        }
        }
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        if($i==3){ 
        $nuevocriterio->periodo='Tercer período';
        }
        $nuevocriterio->save();
        }
        }
        if($infoperiodo=='Cuatrimestre'){
        for($i=1;$i<=2;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nombreespacios=espacioscurriculares::where('id',$infocol[$i])->get();
        foreach($nombreespacios as $nombreesp){
        $nuevocriterio->id_espacio="$nombreesp->nombre";
        }
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        $nuevocriterio->save();
        }
        }
        if($infoperiodo=='Semestre'){
        for($i=1;$i<=2;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nombreespacios=espacioscurriculares::where('id',$infocol[$i])->get();
        foreach($nombreespacios as $nombreesp){
        $nuevocriterio->id_espacio="$nombreesp->nombre";
        } 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        $nuevocriterio->save();
        }
        }
        $infogrado=Grado::where('id_docentes',Auth::user()->idpersona)->where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=Auth::user()->id;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->espacio=$nuevocriterio->id_espacio;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=Auth::user()->id;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->espacio=$nuevocriterio->id_espacio;
        $informe->save();
    }
    }
        }
        }
        if($request->guardar=='1'){
        $valor= $request->guardar;
         return redirect()->route('criteriocreate')->with('success', 'El criterio de evaluación se cargó correctamente.');
        }
        else{
        return redirect()->route('criteriosevaluacion')->with('success', 'El criterio de evaluación se cargó correctamente.');
        }
        }

        /*Docente especial*/
        else{
        $idcolegio=Auth::user()->colegio_id;
        $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
        $check1=$request->aplicagrados;
        $check2=$request->aplicadivisiones;
        $nombregrado=$request->grado;
        if(empty($check1) and empty($check2)){
        if(empty($checkperiodo)){
        $request->validate([
        'criterio' => ['required','max:50'],
        'ponderacion' => ['required','int'],
        'descripcion' => ['max:150'],
        'grado' => ['required'],
        ]);
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->periodo=$request->periodo;
        $nuevocriterio->id_grado=$request->grado;
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
         }
        }
    }
    }
        }
        else{
        $request->validate([
        'criterio' => ['required','max:50'],
        'ponderacion' => ['required','int'],
        'descripcion' => ['max:150'],
        'grado' => ['required'],
        ]);
        if($infoperiodo=='Bimestre'){
        for($i=1;$i<=4;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_grado=$request->grado;
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        if($i==3){ 
        $nuevocriterio->periodo='Tercer período';
        }
        if($i==4){ 
        $nuevocriterio->periodo='Cuarto período';
        }
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        }
        }
        if($infoperiodo=='Trimestre'){
        for($i=1;$i<=3;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_grado=$request->grado; 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        if($i==3){ 
        $nuevocriterio->periodo='Tercer período';
        }
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        }
        }
        if($infoperiodo=='Cuatrimestre'){
        for($i=1;$i<=2;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_grado=$request->grado; 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        }
        }
        if($infoperiodo=='Semestre'){
        for($i=1;$i<=2;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_grado=$request->grado; 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        }
        }
        }       
        }
        elseif(empty($check2) and empty($infoespacio)){
        if(empty($checkperiodo)){
        $request->validate([
        'criterio' => ['required','max:50'],
        'ponderacion' => ['required','int'],
        'descripcion' => ['max:150'],
        'aplicagrados' => ['required'],
        ]);
        $grados=Grado::where('colegio_id',$idcolegio)->get();
        foreach($grados as $grad){
        $descripciongrado[]="$grad->descripcion";
        }
        $contador=count($descripciongrado)-1;
        for($j=0;$j<=$contador;$j++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->periodo=$request->periodo;
        $nuevocriterio->id_grado=$descripciongrado[$j];
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        } 
        }
        else{
        $request->validate([
        'criterio' => ['required','max:50'],
        'ponderacion' => ['required','int'],
        'descripcion' => ['max:150'],
        'espaciocurricular' => ['required'],
        'grado' => ['required'],
        'aplicagrados' => ['required'],
        ]);
        $grados=Grado::where('colegio_id',$idcolegio)->get();
        foreach($grados as $grad){
        $descripciongrado[]="$grad->descripcion";
        }
        $contador=count($descripciongrado)-1;
        for($j=0;$j<=$contador;$j++){
        if($infoperiodo=='Bimestre'){
        for($i=1;$i<=4;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_grado=$descripciongrado[$j];
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        if($i==3){ 
        $nuevocriterio->periodo='Tercer período';
        }
        if($i==4){ 
        $nuevocriterio->periodo='Cuarto período';
        }
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        }
        }
        if($infoperiodo=='Trimestre'){
        for($i=1;$i<=3;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_grado=$descripciongrado[$j]; 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        if($i==3){ 
        $nuevocriterio->periodo='Tercer período';
        }
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        }
        }
        if($infoperiodo=='Cuatrimestre'){
        for($i=1;$i<=2;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_grado=$descripciongrado[$j]; 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        }
        }
        if($infoperiodo=='Semestre'){
        for($i=1;$i<=2;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_grado=$descripciongrado[$j]; 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        }
        }
        }
        }  
        }
        else{
        $request->validate([
        'criterio' => ['required','max:50'],
        'ponderacion' => ['required','int'],
        'descripcion' => ['max:150'],
        'grado'=> ['required'],
        'aplicadivisiones' => ['required'],
        ]);
        $grados=Grado::where('colegio_id',$idcolegio)->get();
        foreach($grados as $grad){
        $descripciongrado[]="$grad->descripcion";
        }
        $contador=count($descripciongrado)-1;
        for($j=0;$j<=$contador;$j++){
        if($infoperiodo=='Bimestre'){
        for($i=1;$i<=4;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_grado=$descripciongrado[$j];
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        if($i==3){ 
        $nuevocriterio->periodo='Tercer período';
        }
        if($i==4){ 
        $nuevocriterio->periodo='Cuarto período';
        }
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        }
        }
        if($infoperiodo=='Trimestre'){
        for($i=1;$i<=3;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_grado=$descripciongrado[$j]; 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        if($i==3){ 
        $nuevocriterio->periodo='Tercer período';
        }
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        }
        }
        if($infoperiodo=='Cuatrimestre'){
        for($i=1;$i<=2;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_grado=$descripciongrado[$j]; 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        }
        }
        if($infoperiodo=='Semestre'){
        for($i=1;$i<=2;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$descripcionaño;
        $nuevocriterio->id_grado=$descripciongrado[$j]; 
        if($i==1){ 
        $nuevocriterio->periodo='Primer período';
        }
        if($i==2){ 
        $nuevocriterio->periodo='Segundo período';
        }
        $nuevocriterio->save();
        $infogrado=Grado::where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($infogrado as $info){
            $docentesespeciales="$info->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$info->descripcion";
           
        $listadoalumnos="$info->id_alumnos";
        $array = preg_replace('/[\[\]\.\;\" "]+/', '', $listadoalumnos);
        $array=explode("," , $array);
        $contador=count($array)-1;
        for($i=0;$i<=$contador;$i++){
        $infoalumno=Alumno::where('id',$array[$i])->get();
        foreach($infoalumno as $infalu){
        $nombrealumnos="$infalu->nombrealumno";
        $apellidoalumnos="$infalu->apellidoalumno";
        $idalumno="$infalu->id";
        }
        $nota=new Notas();
        $nota->docente=$idusuario;
        $nota->criterio=$nuevocriterio->criterio;
        $nota->colegio_id=$idcolegio;
        $nota->periodo=$nuevocriterio->periodo;
        $nota->año=$idaño;
        $nota->nombrealumno=$nombrealumnos;
        $nota->apellidoalumno=$apellidoalumnos;
        $nota->id_alumno=$idalumno;
        $nota->grado=$nuevocriterio->id_grado;
        $nota->save();
        $informe=new Informes();
        $informe->observacion=$request->observacion;
        $informe->año=$idaño;
        $informe->colegio_id=$idcolegio;
        $informe->id_alumno=$idalumno;
        $informe->docente=$idusuario;
        $informe->periodo=$nuevocriterio->periodo;
        $informe->grado=$nuevocriterio->id_grado;
        $informe->save();
        
         }
        }
    }
    }
        }
        }
        }
        }

         
        if($request->guardar=='1'){
        $infogrado=Grado::where('colegio_id',$idcolegio)->orderby('num_grado','ASC')->get();
        foreach($infogrado as $informaciongrado){
        $docentesespeciales="$informaciongrado->id_docentesespe";
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $docentesespeciales=explode(',', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->id){
            $nombresgrado[]="$informaciongrado->descripcion";
            $idgrado[]="$informaciongrado->id";
            }
        }
        }
        $valor= $request->guardar;
        return redirect()->route('criteriocreate')->with('success', 'El criterio de evaluación se cargó correctamente.');
        }
        else{
        return redirect()->route('criteriosevaluacion')->with('success', 'El criterio de evaluación se cargó correctamente.');
        }
        }
    }

    public function editarcriterio(CriteriosEvaluacion $id)
    {
        $idpersona= Auth::user()->idpersona;
        $tipodocente=Docente::where('id',$idpersona)->get();
        foreach($tipodocente as $tipo){
            $tipodoc="$tipo->especialidad";
        }
        $idcolegio=Auth::user()->colegio_id;
        $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
        $infocolegio=Colegio::where('id',$idcolegio)->get();
        foreach($infocolegio as $info){
            $infocol="$info->espacioscurriculares";
            $informacionperiodo="$info->periodo";
        }
        if($tipodoc=='Grado'){
        $infocol = preg_replace('/[\[\]\.\;\""]+/', '', $infocol);
        $infocol=explode(',', $infocol);
        $contador=count($infocol)-1;
        for ($i=0; $i <= $contador ; $i++) { 
        $nombreespacios[]=espacioscurriculares::where('id',$infocol[$i])->pluck("nombre");
        }
        return view('Criterios.editarcriterio',compact('id','tipodoc','infoaño','nombreespacios','informacionperiodo'));
        }
        if($tipodoc!='Grado'){
        $infogrado=Grado::where('colegio_id',$idcolegio)->orderby('num_grado','ASC')->get();
        foreach($infogrado as $informaciongrado){
        $docentesespeciales="$informaciongrado->id_docentesespe";
        $docentesespeciales=explode(',', $docentesespeciales);
        $docentesespeciales = preg_replace('/[\[\]\.\;\" "]+/', '', $docentesespeciales);
        $contador=count($docentesespeciales)-1;
        for($i=0;$i<=$contador;$i++){
            if($docentesespeciales[$i]==Auth::user()->idpersona){
            $nombresgrado[]="$informaciongrado->descripcion";
            $idgrado[]="$informaciongrado->id";
            }
        }
        }
        return view('Criterios.editarcriterio',compact('id','tipodoc','infoaño','nombresgrado','idgrado','informacionperiodo'));
        }
    }
    public function update(Request $request,$id)
    {
        $criterio = CriteriosEvaluacion::findOrFail($id);

        $idpersona= Auth::user()->idpersona;
        $tipodocente=Docente::where('id',$idpersona)->get();
        foreach($tipodocente as $tipo){
            $tipodoc="$tipo->especialidad";
        }
        if($tipodoc=='Grado'){
        $nombreespaciocurri=$request->espaciocurricular;
        $idcolegio=Auth::user()->colegio_id;
        $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
        $infocolegio=Colegio::where('id',$idcolegio)->get();
        foreach($infocolegio as $info){
            $infocol="$info->espacioscurriculares";
        }
        $infocol = preg_replace('/[\[\]\.\;\" "]+/', '', $infocol);
        $infocol=explode(',', $infocol);
        $data= $request->only('criterio','ponderacion','descripcion','espaciocurricular','periodo');
        $criterio->update($data);
        return redirect()->route('criteriosevaluacion')->with('success','El criterio de evaluación se modificó correctamente.');
    }
    else{
        $idcolegio=Auth::user()->colegio_id;
        $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
        $nombregrado=$request->grado;
        $request->validate([
        'criterio' => ['required','max:50'],
        'ponderacion' => ['required','int'],
        'descripcion' => ['max:150'],
        'grado' => ['required'],
        'periodo' => ['required'],
        ]);        
        
        $data= $request->only('criterio','ponderacion','descripcion','grado','periodo');
        $criterio->update($data);
        return redirect()->route('criteriosevaluacion')->with('success','El criterio de evaluación se modificó correctamente.');
        }
    }
     public function destroy(CriteriosEvaluacion $id)
    {
        $id->delete();
        return back()->with('success','El criterio de evaluación se eliminó correctamente.');
    }
}
