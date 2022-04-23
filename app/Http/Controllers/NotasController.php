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
    $infoinformes=Informes::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('grado',$grado)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->get();
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

    return view('notas.index',compact('infoaño','informacionperiodo','nombresgrado','grado','periodo','tipodoc','id','infoalumnos','infocriterios','califi','infoinformes','califica'));   

 
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
    $infonotas=Informes::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('grado',$grado)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->pluck("id_alumno");
    $conta=count($infonotas)-1;
    $data= $request->observacion;
    for($i=0;$i<=$conta;$i++){
        if($infonotas[$i]==$id_alumno){
            $busquedaInformes=Informes::where('id_alumno', $id_alumno)->where('grado',$grado)->first();
            $busquedaInformes->observacion=$data[$i]; 
            $busquedaInformes->save();
        }
    }
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
    $infonotas=Informes::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('espacio',$espacio)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->pluck("id_alumno");
    $conta=count($infonotas)-1;
    $data= $request->observacion;
    for($i=0;$i<=$conta;$i++){
        if($infonotas[$i]==$id_alumno){
            $busquedaInformes=Informes::where('id_alumno', $id_alumno)->where('espacio',$espacio)->first();
            $busquedaInformes->observacion=$data[$i]; 
            $busquedaInformes->save();
        }
    }
    return redirect()->back()->with('success', 'Los observaciones se guardaron correctamente.');
    }  
  }

  public function updatenota(Request $request,$id_alumno)
    {
    $idpersona= Auth::user()->idpersona;
    $tipodocente=Docente::where('id',$idpersona)->get();
    foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
    }
    $cali=$request->calificacion;
    $periodo=$request->periodo;
    $idcolegio=Auth::user()->colegio_id;
    $infoaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->get();
     foreach($infoaño as $activo){
      $añoactivo="$activo->id";
      $descripcionaño="$activo->descripcion";
    }

    if($tipodoc=='Grado'){
    $espacio=$request->espacio;
    $infonotas=Informes::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('espacio',$espacio)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->pluck("id_alumno");
    $informacionnot=Informes::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('espacio',$espacio)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->get();
    $infonot=Notas::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('espacio',$espacio)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->get();
    $infoalumnos=$informacionnot->unique('nombrealumno','apellidoalumno');
    $infocriterios=$infonot->unique('criterio');
    foreach($infocriterios as $infocrit) 
        {
            $criterio[]=$infocrit->criterio;
        }
    $cantidadnotas=count($cali)-1;          
    $contador=count($criterio);
    for ($i=0;$i<=$cantidadnotas;$i=$i+$contador){
        $elemento=floor($i/$contador);
        for($j=0;$j<$contador;$j++){
            $busquedaNotas=Notas::where('id_alumno',$infonotas[$elemento])->where('criterio',$criterio[$j])->first();
            $busquedaNotas->nota=$cali[$i+$j]; 
            $busquedaNotas->save();
        }
    }
    foreach($infocriterios as $criterio){
        $nombrecriterio[]="$criterio->criterio";
    }
    $contcriterio=count($nombrecriterio)-1;
    for($i=0;$i<=$contcriterio;$i++){
        $pondecriterios[]=CriteriosEvaluacion::where('criterio',$nombrecriterio[$i])->pluck("ponderacion");
    }
    $pondecriterios = preg_replace('/[\[\]\.\;\""]+/', '', $pondecriterios);
    $sumaponderacion=array_sum($pondecriterios);
    foreach($infoalumnos as $infoalu){
        $idalumnos[]="$infoalu->id_alumno";
    }
    $contalu=count($idalumnos)-1;
    for ($i=0; $i <=$contalu ; $i++) { 
    $informacionnota[]=Notas::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('espacio',$espacio)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->where('id_alumno',$idalumnos[$i])->pluck('nota');
    }
    $contnota=count($informacionnota)-1;
    for ($i=0; $i <=$contnota ; $i++) {
    $contotal=count($informacionnota[$i])-1;
    $variable=$informacionnota[$i];
    for ($j=0; $j <=$contotal ; $j++) { 
        $valornota[]=calificacioncualitativa::where('codigo',$variable[$j])->pluck('valor');
    }
}

$variable = preg_replace('/[\[\]\\;\""]+/', '', $valornota);
$cont1=count($variable)-1;
$cont2=count($pondecriterios)-1;
$cont3=count($pondecriterios);

for ($i=0; $i <=$cont1 ; $i=$i+$cont3) { 
     $suma=0;
    for ($j=0; $j <=$cont2 ; $j++) { 
    $suma=$suma+($pondecriterios[$j] * $variable[$i+$j]);
    }
    $array[]=$suma;
}
$contarray=count($array)-1;
for($i=0;$i<=$contarray;$i++){
    $calculototal[]=$array[$i]/$sumaponderacion;
}
$contadortotal=count($calculototal)-1;
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
        $calificacion[]=calificacioncualitativa::where('id_calificacion',$infocali[$i])->pluck("codigo");
        }
        }
        else
        {
        $infoco=explode(',', $infoco);
        $infoco = preg_replace('/[\[\]\.\;\""]+/', '', $infoco);
        $minimo= head($infoco);
        $maximo= last($infoco);
        for ($i=$minimo; $i <= $maximo ; $i++) { 
        $calificacion[]=$i;
        }
      }
      
$contadorcalificacion=count($calificacion)-1;
$calificacion = preg_replace('/[\[\]\.\;\""]+/', '', $calificacion);
$infoinf=Informes::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('espacio',$espacio)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->get();
$infosofi=Informes::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('espacio',$espacio)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->first();
$contadorinformes=count($infoinf)-1;
for ($h=0; $h <=$contadorinformes ; $h++) { 
for($i=0;$i<=$contadortotal;$i++){
    if(1<=$calculototal[$i] and $calculototal[$i]<=3){
        $infonota[]='NS';
    }
    elseif(3<$calculototal[$i] and $calculototal[$i]<=5){
        for($j=0;$j<=$contadorcalificacion;$j++){
        if($calificacion[$j]=='S'){
            $infonota[]='S';
        }
        if($calificacion[$j]=='I'){
            $infonota[]='I';
        }
    }
} 
 elseif(5<$calculototal[$i] and $calculototal[$i]<=7){
        for($j=0;$j<=$contadorcalificacion;$j++){
        if($calificacion[$j]=='R'){
            $infonota[]='R';
        }
        if($calificacion[$j]=='B'){
            $infonota[]='B';
        }
    }
}
 elseif(7<$calculototal[$i] and $calculototal[$i]<=9){
        $infonota[]='MB';
    } 
 elseif(9<$calculototal[$i]){
        for($j=0;$j<=$contadorcalificacion;$j++){
        if($calificacion[$j]=='E'){
            $infonota[]='E';
        }
        if($calificacion[$j]=='SB'){
            $infonota[]='SB';
        }
    }
}
}
$infosofi->nota=$infonota[$h];
$infosofi->save();
}  
    
    }
    if($tipodoc!='Grado'){
    $grado=$request->grado;
    $infonotas=Informes::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('grado',$grado)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->pluck("id_alumno");
    $infonot=Notas::where('docente',Auth::user()->id)->where('periodo',$periodo)->where('grado',$grado)->where('colegio_id',$idcolegio)->where('año',$añoactivo)->get();
    $infocriterios=$infonot->unique('criterio');
    foreach($infocriterios as $infocrit) 
        {
            $criterio[]=$infocrit->criterio;
        }
    $cantidadnotas=count($cali)-1;          
    $contador=count($criterio);
    for ($i=0;$i<=$cantidadnotas;$i=$i+$contador){
        $elemento=floor($i/$contador);
        for($j=0;$j<$contador;$j++){
            $busquedaNotas=Notas::where('id_alumno',$infonotas[$elemento])->where('criterio',$criterio[$j])->first();
            $busquedaNotas->nota=$cali[$i+$j]; 
            $busquedaNotas->save();
        }
    }
     return redirect()->back()->with('success', 'Las notas se guardaron correctamente.');
    }
}
}