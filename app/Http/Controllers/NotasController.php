<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Año;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\Colegio;
use App\Models\Alumno;
use App\Models\Notas;
use App\Models\CriteriosEvaluacion;
use App\Models\espacioscurriculares;
use App\Models\calificacioncualitativa;
use App\Models\Informes;

class NotasController extends Controller
{
    public function __construct()
   {
    $this->middleware('auth');
   }

    public function buscador()
   {
    $idcolegio=Auth::user()->colegio_id;
    $idpersona= Auth::user()->idpersona;
    $tipodocente=Docente::where('id',$idpersona)->get();
    foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
    }
    $infoperiodo=Colegio::where('id',$idcolegio)->get();
    foreach($infoperiodo as $infoperi){
      $informacionperiodo="$infoperi->periodo";
    }
    $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
    $infocolegio=Colegio::where('id',$idcolegio)->get();
      foreach($infocolegio as $info){
            $infocol="$info->espacioscurriculares";
      }
    if($tipodoc=='Grado'){
        $infocol = preg_replace('/[\[\]\.\;\""]+/', '', $infocol);
        $infocol=explode(',', $infocol);
        $contador=count($infocol)-1;
        for ($i=0; $i <= $contador ; $i++) { 
        $nombreespacios[]=espacioscurriculares::where('id',$infocol[$i])->pluck("nombre");
        }
      return view('notas.buscador',compact('infoaño','nombreespacios','tipodoc','informacionperiodo'));
    }
    else{
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
      return view('notas.buscador',compact('infoaño','nombresgrado','informacionperiodo','tipodoc'));
      }
   }
  
  public function index(Request $request, Notas $id)
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
      $añoactivo="$activo->id";
      $descripcionaño="$activo->descripcion";
    }
    $periodo=$request->periodo;
    $infocole=Colegio::where('id',$idcolegio)->get();
      foreach($infocole as $info){
            $infoco="$info->calinumerica";
            $infocali="$info->calicualitativa";
      }
      if($infoco==NULL)
        {
        $infocali = preg_replace('/[\[\]\.\;\""]+/', '', $infocali);
        $infocali=explode(',', $infocali);
        $contador=count($infocali)-1;
        for ($i=0; $i <= $contador ; $i++) { 
        $califi[]=calificacioncualitativa::where('id_calificacion',$infocali[$i])->pluck("codigo");
        $califica[]=calificacioncualitativa::where('id_calificacion',$infocali[$i])->pluck("calificacion");
     
        }
        }
        else
        {
        $infoco=explode(',', $infoco);
        $infoco = preg_replace('/[\[\]\.\;\""]+/', '', $infoco);
        $minimo= head($infoco);
        $maximo= last($infoco);
        for ($i=$minimo; $i <= $maximo ; $i++) { 
        $califi[]=$i;
        }
      }
    if($tipodoc!='Grado'){
    $grado=$request->grado;
    $request->validate([
            'grado' => ['required'],
            'periodo' => ['required'],
    ]);
    $infonotas=Notas::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('grado',$grado)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->get();
    $infoalumnos=$infonotas->unique('nombrealumno')->unique('apellidoalumno');
    $infocriterios=$infonotas->unique('criterio');
    $infoinformes=Informes::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('espacio',$espacio)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->get();
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
    return view('notas.index',compact('infoaño','informacionperiodo','nombresgrado','grado','periodo','tipodoc','id','infonotas','infoalumnos','infocriterios','califi','infoinformes','califica'));   
    }
    else{
    $espacio=$request->espacio;
    $request->validate([
            'espacio' => ['required'],
            'periodo' => ['required'],
    ]);
    $infonotas=Notas::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('espacio',$espacio)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->get();
    $infoalumnos=$infonotas->unique('nombrealumno','apellidoalumno');
    $infocriterios=$infonotas->unique('criterio');
    $infoinformes=Informes::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('espacio',$espacio)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->get();
    $infocolegio=Colegio::where('id',$idcolegio)->get();
      foreach($infocolegio as $info){
            $infocol="$info->espacioscurriculares";
      }
    $infocol = preg_replace('/[\[\]\.\;\""]+/', '', $infocol);
        $infocol=explode(',', $infocol);
        $contador=count($infocol)-1;
        for ($i=0; $i <= $contador ; $i++) { 
        $nombreespacios[]=espacioscurriculares::where('id',$infocol[$i])->pluck("nombre");
        }

   
    return view('notas.index',compact('infoaño','informacionperiodo','periodo','espacio','tipodoc','nombreespacios','infonotas','id','infocriterios','infoalumnos', 'califi','infoinformes','califica'));
  }
}
    public function updateobservacion(Request $request,$id_alumno)
    {
       $idcolegio=Auth::user()->colegio_id;
       $infoperiodo=Colegio::where('id',$idcolegio)->get();
       foreach($infoperiodo as $infoperi){
       $informacionperiodo="$infoperi->periodo";
      }
     $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
     foreach($infoaño as $activo){
      $añoactivo="$activo->id";
      $descripcionaño="$activo->descripcion";
    }
    $periodo=$request->periodo;
    return $periodo;
    $idpersona= Auth::user()->idpersona;
    $tipodocente=Docente::where('id',$idpersona)->get();
    foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
    }
    $alumnonota=Notas::findOrFail($id_alumno);
    $alu=Notas::where('id',$id_alumno)->get();
    foreach($alu as $nombre){
      $nomalu="$nombre->nombrealumno";
      $apealu="$nombre->apellidoalumno";
    }
    $infalumno=Alumno::where('nombrealumno', $nomalu)->where('apellidoalumno',$apealu)->get();
    foreach($infalumno as $informacionalumno){
      $idalumno="$informacionalumno->id";
    }
    if($tipodoc!='Grado'){
    $grado=$request->grado;
    $infonotas=Notas::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('grado',$grado)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->get();
    $infoalumnos=$infonotas->unique('nombrealumno');
    $infocriterios=$infonotas->unique('criterio');
    $busquedaInformes=Informes::where('id_alumno', $id_alumno);
    $data= $request->only('observacion','nota');
    $busquedaInformes->update($data);
    return redirect()->back()->with('success', 'Los observaciones se guardaron correctamente.');
    }
    if($tipodoc=='Grado'){
    $infocolegio=Colegio::where('id',$idcolegio)->get();
      foreach($infocolegio as $info){
            $infocol="$info->espacioscurriculares";
      }
        $infocol = preg_replace('/[\[\]\.\;\""]+/', '', $infocol);
        $infocol=explode(',', $infocol);
        $contador=count($infocol)-1;
        for ($i=0; $i <= $contador ; $i++) { 
        $nombreespacios[]=espacioscurriculares::where('id',$infocol[$i])->pluck("nombre");
        }
    $espacio=$request->espacio;
    $infonotas=Notas::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('espacio',$espacio)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->get();
    $infoalumnos=$infonotas->unique('nombrealumno');
    $infocriterios=$infonotas->unique('criterio');
    $busquedaInformes=Informes::where('id_alumno', $id_alumno);
    $data= $request->only('observacion','nota');
    $busquedaInformes->update($data);
    return redirect()->back()->with('success', 'Los observaciones se guardaron correctamente.');
    }  
  }

  public function updatenota(Request $request,$id)
    {

    $cali=$request->calificacion; 
    $idcolegio=Auth::user()->colegio_id;
    $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
     foreach($infoaño as $activo){
      $añoactivo="$activo->id";
      $descripcionaño="$activo->descripcion";
    }

    $infonotas=Notas::where('docente',Auth::user()->id)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->get();

    
    $infocriterios=$infonotas->unique('criterio');
    foreach($infocriterios as $infocrit) 
        {
            $criterio[]=$infocrit->criterio;
        }          
    $contador=count($criterio)-1;
    for ($i=0; $i <=$contador ; $i++) { 
        
        $crit=$criterio[$i];
        $nota=$cali[$i];
       
    }
    return $cali; 

       $busquedaNotas=Notas::where('id_alumno', $id)->where('grado', $per)->get();
       
      $data= $request->only('observacion','nota');
    $busquedaInformes->update($data);
     
    }
}