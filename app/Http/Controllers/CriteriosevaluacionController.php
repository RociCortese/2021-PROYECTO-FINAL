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
    $datoscriterio= CriteriosEvaluacion::where('id_usuario',$idusuario)->especialidad($especialidad)->año($añoescolar)->orderby('id','ASC')->paginate(5);
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
        }
        if($tipodoc=='Grado'){
        $infocol = preg_replace('/[\[\]\.\;\" "]+/', '', $infocol);
        $infocol=explode(',', $infocol);
        $contador=count($infocol)-1;
        for ($i=0; $i <= $contador ; $i++) { 
        $nombreespacios[]=espacioscurriculares::where('id',$infocol[$i])->pluck("nombre");
        }
        return view('Criterios.create',compact('tipodoc','infoaño','nombreespacios'));
        }
        if($tipodoc!='Grado'){
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
        return view('Criterios.create',compact('tipodoc','infoaño','nombresgrado','idgrado'));
        }
    }
    public function store(Request $request)
    {
        $idpersona= Auth::user()->idpersona;
        $tipodocente=Docente::where('id',$idpersona)->get();
        foreach($tipodocente as $tipo){
            $tipodoc="$tipo->especialidad";
        }
        if($tipodoc=='Grado'){
         $request->validate([
            'criterio' => ['required','max:50'],
            'ponderacion' => ['required','int'],
            'descripcion' => ['max:150'],
            //'espaciocurricular' => ['required'],
        ]);
        $check=$request->aplicaespacios;
        $idcolegio=Auth::user()->colegio_id;
        $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
        if(empty($check)){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        foreach($infoaño as $info){
        $nuevocriterio->id_año="$info->descripcion";
        }
        $nuevocriterio->id_espacio=$request->espaciocurricular;
        $nuevocriterio->save(); 
        }
        else{
        $infocolegio=Colegio::where('id',$idcolegio)->get();
        foreach($infocolegio as $info){
            $infocol="$info->espacioscurriculares";
        }
        $infocol = preg_replace('/[\[\]\.\;\" "]+/', '', $infocol);
        $infocol=explode(',', $infocol);
        $contador=count($infocol)-1;
        for ($i=0; $i <= $contador ; $i++) { 
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        foreach($infoaño as $info){
        $nuevocriterio->id_año="$info->descripcion";
        }
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nombreespacios=espacioscurriculares::where('id',$infocol[$i])->get();
        foreach($nombreespacios as $nombreesp){
        $nuevocriterio->id_espacio="$nombreesp->nombre";
        }
        $nuevocriterio->save();
        }
        }       
        return redirect()->route('criteriosevaluacion')->with('success', 'El criterio de evaluación se cargó correctamente.');
        }


         if($tipodoc!='Grado'){
         $request->validate([
            'criterio' => ['required','max:50'],
            'ponderacion' => ['required','int'],
            'descripcion' => ['max:150'],
        ]);
        $idcolegio=Auth::user()->colegio_id;
        $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
        $check1=$request->aplicagrados;
        $check2=$request->aplicadivisiones;
        if(empty($check1) and empty($check2)){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        foreach($infoaño as $info){
        $nuevocriterio->id_año="$info->descripcion";
        }
        $nuevocriterio->id_grado=$request->grado;
        $nuevocriterio->save();        
        return redirect()->route('criteriosevaluacion')->with('success', 'El criterio de evaluación se cargó correctamente.');
        }
        $nuevocriterio->id_espacio=$request->espaciocurricular;
        $nuevocriterio->save(); 
        }
        $infoespacio=$request->espaciocurricular;

        if(empty($check1) and empty($infoespacio)){
        $infocolegio=Colegio::where('id',$idcolegio)->get();
        foreach($infocolegio as $info){
            $infocol="$info->espacioscurriculares";
        }
        $infocol = preg_replace('/[\[\]\.\;\" "]+/', '', $infocol);
        $infocol=explode(',', $infocol);
        $contador=count($infocol)-1;
        for ($i=0; $i <= $contador ; $i++) { 
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        foreach($infoaño as $info){
        $nuevocriterio->id_año="$info->descripcion";
        }
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->save();
        }
        }
        if(empty($check2) and empty($infoespacio)){
        $grados=Grado::where('colegio_id',$idcolegio)->get();
        foreach($grados as $grad){
        $descripciongrado[]="$grad->descripcion";
        }
        $contador=count($descripciongrado)-1;
        for($i=0;$i<=$contador;$i++){
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        foreach($infoaño as $info){
        $nuevocriterio->id_año="$info->descripcion";
        }
        $idcolegio=Auth::user()->colegio_id;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_grado=$descripciongrado[$i];
        $nuevocriterio->save();
        }
       
        }           
        return redirect()->route('criteriosevaluacion')->with('success', 'El criterio de evaluación se cargó correctamente.');
        }
   }

     public function destroy(CriteriosEvaluacion $id)
    {
        $id->delete();
        return back()->with('success','El criterio de evaluación se eliminó correctamente.');
    }
}
