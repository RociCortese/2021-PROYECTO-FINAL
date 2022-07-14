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
use App\Models\Informes;
use App\Models\espacioscurriculares;
use App\Models\calificacioncualitativa;

class InformacionAcademicaController extends Controller
{
    public function __construct()
   {
    $this->middleware('auth');
   }
   public function getAutocompletealumno (Request $request){
    $data = [];
    $idcolegio=Auth::user()->colegio_id;
    if($request->has('q')){
    $search = $request->q;
    $data =Alumno::select("id","nombrecompleto")
          ->where('nombrecompleto','LIKE',"%$search%")
          ->where('colegio_id',$idcolegio)
          ->get();
        }
    return response()->json($data);
   }

    public function buscador(Request $request)
    {
    $idcolegio=Auth::user()->colegio_id;
    $años=Año::where('id_colegio',$idcolegio)->where('estado','!=','inactivo')->orderBy('descripcion','ASC')->pluck("descripcion");
    $infocolegio=Colegio::where('id',$idcolegio)->pluck("espacioscurriculares");
    $infocolegio = preg_replace('/[\[\]\.\;\" "]+/', '', $infocolegio);
    $infocolegio = str_replace('\\','',$infocolegio); 
    $infocolegio=explode(',',$infocolegio);
    $contadorespacios=count($infocolegio)-1;
    for ($i=0; $i <=$contadorespacios ; $i++) { 
    $nombreespacio[]=espacioscurriculares::where('id',$infocolegio[$i])->pluck("nombre");
    }
    $nombreespacio = preg_replace('/[\[\]\.\;\""]+/', '', $nombreespacio);
    $grados=Grado::where('colegio_id',$idcolegio)->get();
    $grado=$grados->unique('descripcion');
    foreach($grado as $infogrado){
        $informaciongrado[]="$infogrado->descripcion";
    }
    return view('InformacionAcademica.buscador',compact('años','nombreespacio','informaciongrado'));
    }
     public function index(Request $request)
    {
    $idcolegio=Auth::user()->colegio_id;
    $infgrado = trim($request->get('grado'));
    $alumno = trim($request->get('alumno'));
    $nombrealumno=Alumno::where('id',$alumno)->where('colegio_id',$idcolegio)->pluck("nombrecompleto");
    $nombrealumno = preg_replace('/[\[\]\.\;\""]+/', '', $nombrealumno);
    $espaciocurricular = trim($request->get('espaciocurricular'));
    $añolectivo = trim($request->get('añolectivo'));
    $añolectivo=Año::where('id_colegio',$idcolegio)->where('descripcion',$añolectivo)->pluck("id");
    $añolectivo = preg_replace('/[\[\]\.\;\""]+/', '', $añolectivo);
    $años=Año::where('id_colegio',$idcolegio)->where('estado','!=','inactivo')->orderBy('descripcion','ASC')->pluck("descripcion");
    $añolec = trim($request->get('añolectivo'));
    $infocolegio=Colegio::where('id',$idcolegio)->pluck("espacioscurriculares");
    $infocolegio = preg_replace('/[\[\]\.\;\" "]+/', '', $infocolegio);
    $infocolegio = str_replace('\\','',$infocolegio); 
    $infocolegio=explode(',',$infocolegio);
    $contadorespacios=count($infocolegio)-1;
    for ($i=0; $i <=$contadorespacios ; $i++) { 
    $nombreespacio[]=espacioscurriculares::where('id',$infocolegio[$i])->pluck("nombre");
    }
    $nombreespacio = preg_replace('/[\[\]\.\;\""]+/', '', $nombreespacio);
    $grados=Grado::where('colegio_id',$idcolegio)->get();
    $grado=$grados->unique('descripcion');
    foreach($grado as $infogrado){
        $informaciongrado[]="$infogrado->descripcion";
    }
    $informacionperiodo=Colegio::where('id',$idcolegio)->pluck("periodo");
    $informacionperiodo = preg_replace('/[\[\]\.\;\" "]+/', '', $informacionperiodo);
    if(empty($request->grado) and empty($request->alumno) and empty($request->espaciocurricular) or empty($request->grado) and empty($request->alumno) and empty($request->añolectivo) or empty($request->grado) and empty($request->espaciocurricular) and empty($request->añolectivo) or empty($request->alumno) and empty($request->espaciocurricular) and empty($request->añolectivo)){
    return back()->with('danger', 'Debe seleccionar al menos dos criterios.');
    }
    $ingrado = Informes::
           grados($infgrado)
           ->años($añolectivo)
           ->alumnos($alumno)
           ->espacios($espaciocurricular)
           ->where('colegio_id',$idcolegio)
           ->get();
    $inforgrado=Informes::
           grados($infgrado)
           ->años($añolectivo)
           ->alumnos($alumno)
           ->espacios($espaciocurricular)
           ->where('colegio_id',$idcolegio)
           ->select('id_alumno','espacio','año','grado')
           ->distinct()
           ->paginate(10);
    return view('InformacionAcademica.index',compact('inforgrado','años','nombreespacio','informaciongrado','infgrado','añolec','nombrealumno','espaciocurricular','informacionperiodo','ingrado','alumno'));
    }
    public function showChart(Request $request){
        $idcolegio=Auth::user()->colegio_id;
        $año=Año::where('id_colegio',$idcolegio)->get();
        $años= [];
        foreach ($año as $todosaños) {
           $años[]="$todosaños->descripcion";
           $idaños[]="$todosaños->id";
        }
        $espacios= [];
        $espacioscurriculares=Colegio::where('id',$idcolegio)->get();
        foreach($espacioscurriculares as $espacios){
        $espaciocurricular="$espacios->espacioscurriculares";
        }
        $espaciocurricular=explode(',',$espaciocurricular);
        $espaciocurricular = preg_replace('/[\[\]\.\;\""]+/', '', $espaciocurricular);
        $contadorespacios=count($espaciocurricular)-1;
        for ($i=0; $i <=$contadorespacios ; $i++) { 
        $nombrespacio[] = espacioscurriculares::where('id',$espaciocurricular[$i])->pluck("nombre");
        } 
        $nombrespacio = preg_replace('/[\[\]\.\;\""]+/', '', $nombrespacio);
        $periodos=Colegio::where('id',$idcolegio)->get();
        foreach ($periodos as $todosperiodos) {
           $periodo="$todosperiodos->periodo";
        }
        $tipocalificacion=Colegio::where('id',$idcolegio)->get();
        foreach ($tipocalificacion as $calificacion) {
           $calificacioncuali="$calificacion->calicualitativa";
        }
        $calificacioncuali = preg_replace('/[\[\]\.\;\""]+/', '', $calificacioncuali);        
        if(empty($calificacioncuali)){
        $nombrescalificaciones[]=null;
        }
        else{
        $calificacioncuali=explode(',',$calificacioncuali);
        $contador=count($calificacioncuali)-1;
        for ($i=0; $i <=$contador ; $i++) { 
        $nombrescalificaciones[]=calificacioncualitativa::where('id_calificacion',$calificacioncuali[$i])->pluck("codigo");   
        }
        }
        $per=[];
        if(empty($request->grado) and empty($request->añolectivo)){
        $alumno=$request->alumno;
        $nombrealumno=Alumno::where('nombrecompleto',$alumno)->pluck("id");
        $nombrealumno = preg_replace('/[\[\]\.\;\""]+/', '', $nombrealumno);
        $espacio=$request->espacio;
        if($periodo=='Bimestre'){
            $notasperiodo1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Primer período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Segundo período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo3 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Tercer período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo4 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Cuarto período')->orderBy('año','ASC')->pluck("nota");
            $notas1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Primer período')->orderBy('año','ASC')->get();
            $notas2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Segundo período')->orderBy('año','ASC')->get();
            $notas3 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Tercer período')->orderBy('año','ASC')->get();
            $notas4 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Cuarto período')->orderBy('año','ASC')->get();
            $notasperiodo1=[];
            $notasperiodo2=[];
            $notasperiodo3=[];
            $notasperiodo4=[];
            $contadoraños=count($años)-1;
            for ($i=0; $i <=$contadoraños; $i++) {
            if(sizeof($notas1)==0){
            $notasperiodo1[$i]=null;
            }
            else{
            foreach ($notas1 as $nota1) {
             if($nota1->año==$idaños[$i]){
                $notasperiodo1[$i]=$nota1->nota;
                break;
            }
            else{
                $notasperiodo1[$i]=null;
            }    
            }
            }
            if(sizeof($notas2)==0){
            $notasperiodo2[$i]=null;
            }
            else{
            foreach ($notas2 as $nota2) {
             if($nota2->año==$idaños[$i]){
                $notasperiodo2[$i]=$nota2->nota;
                 break;
            }    
             else{
                $notasperiodo2[$i]=null;
            }    
            }
            } 
            if(sizeof($notas3)==0){
            $notasperiodo3[$i]=null;
            }
            else{  
            foreach ($notas3 as $nota3) {
             if($nota3->año==$idaños[$i]){
                $notasperiodo3[$i]=$nota3->nota;
                break;
            }
            else{
                $notasperiodo3[$i]=null;
            }    
            }
            }
            if(sizeof($notas4)==0){
            $notasperiodo4[$i]=null;
            }
            else{
            foreach ($notas4 as $nota4) {
             if($nota4->año==$idaños[$i]){
                $notasperiodo4[$i]=$nota4->nota;
                break;
            }
            else{
                $notasperiodo4[$i]=null;
            }    
            }
            }
            }
            for ($i=0; $i <=$contadoraños; $i++) {
            if(empty($calificacioncuali)){
            $cantidadnotas=0;
            if($notasperiodo1[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo2[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo3[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo4[$i]!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas==0){
            $notasprom[$i]=null;
            }
            else{
            $suma=$notasperiodo1[$i]+$notasperiodo2[$i]+$notasperiodo3[$i]+$notasperiodo4[$i];
            $notasprom[$i]=$suma/$cantidadnotas;
            }
            }
            else{
            $cantidadnotas=0;
            $puntos1=calificacioncualitativa::where('codigo',$notasperiodo1[$i])->pluck("valor");
            $puntos1 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos1));
            if($puntos1!=null){
                $cantidadnotas++;
            }
            $puntos2=calificacioncualitativa::where('codigo',$notasperiodo2[$i])->pluck("valor");
            $puntos2 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos2));
            if($puntos2!=null){
                $cantidadnotas++;
            }
            $puntos3=calificacioncualitativa::where('codigo',$notasperiodo3[$i])->pluck("valor");
            $puntos3 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos3));
            if($puntos3!=null){
                $cantidadnotas++;
            }
            $puntos4=calificacioncualitativa::where('codigo',$notasperiodo4[$i])->pluck("valor");
            $puntos4 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos4));
            if($puntos4!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas!=0){ 
            $suma=$puntos1+$puntos2+$puntos3+$puntos4;
            $promedio=$suma/$cantidadnotas;
            if(1<=$promedio and $promedio<=3){
            $calcuali[$i]='NS';
            }
            elseif(3<$promedio and $promedio<=5){
            $calcuali[$i]='S';
            } 
            elseif(5<$promedio and $promedio<=7){
            $calcuali[$i]='B';
            }
            elseif(7<$promedio and $promedio<=9){
            $calcuali[$i]='MB';
            } 
            elseif(9<$promedio){
            $calcuali[$i]='E';
            }
            }
            else{
            $calcuali[$i]=null; 
            }
            }
            }
            $notasperiodo1 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo1);
            $contador1=count($notasperiodo1);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador1 ; $i++) {
            $notasperi1[]=floatval($notasperiodo1[$i]);   
            }
            }
            else{
            $valorcali[]=' ';
            $nombrescalificaciones=array_merge($valorcali,$nombrescalificaciones);
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador1 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo1[$i]==$nombrescali[$j]){
            $notasperi1[$i]=$j;
            break;
            }
            elseif($notasperiodo1[$i]==null){
                $notasperi1[$i]=0;
            }
            }
            }
            for ($i=0; $i <=$contadoraños ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($calcuali[$i]==$nombrescali[$j]){
            $notasprom[]=$j;
            }
            }
            }
            }
            $notasperiodo2 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo2);
            $contador2=count($notasperiodo2);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador2 ; $i++) {
            $notasperi2[]=floatval($notasperiodo2[$i]);   
            }
            }
            else{
            $valorcali[]=' ';
            $nombrescalificaciones=array_merge($valorcali,$nombrescalificaciones);
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador2 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo2[$i]==$nombrescali[$j]){
            $notasperi2[$i]=$j;
            break;
            }
            elseif($notasperiodo2[$i]==null){
                $notasperi2[$i]=0;
            }
            }
            }
            for ($i=0; $i <=$contadoraños ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($calcuali[$i]==$nombrescali[$j]){
            $notasprom[]=$j;
            }
            }
            }
            }
            $notasperiodo3 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo3);
            $contador3=count($notasperiodo3);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador3 ; $i++) {
            $notasperi3[]=floatval($notasperiodo3[$i]);   
            }
            }
            else{
            $valorcali[]=' ';
            $nombrescalificaciones=array_merge($valorcali,$nombrescalificaciones);
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador3 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo3[$i]==$nombrescali[$j]){
            $notasperi3[$i]=$j;
            break;
            }
            elseif($notasperiodo3[$i]==null){
                $notasperi3[$i]=0;
            }
            }
            }
            for ($i=0; $i <=$contadoraños ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($calcuali[$i]==$nombrescali[$j]){
            $notasprom[]=$j;
            }
            }
            }
            }
            $notasperiodo4 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo4);
            $contador4=count($notasperiodo4);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador4 ; $i++) {
            $notasperi4[]=floatval($notasperiodo4[$i]);   
            }
            }
            else{
            $valorcali[]=' ';
            $nombrescalificaciones=array_merge($valorcali,$nombrescalificaciones);
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador4 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo4[$i]==$nombrescali[$j]){
            $notasperi4[$i]=$j;
            break;
            }
            elseif($notasperiodo4[$i]==null){
                $notasperi4[$i]=0;
            }
            }
            }
            for ($i=0; $i <=$contadoraños ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($calcuali[$i]==$nombrescali[$j]){
            $notasprom[]=$j;
            }
            }
            }
            }
            $per1='Primer período';
            $per2='Segundo período';
            $per3='Primer período';
            $per4='Segundo período';
            return view("Graficos.Grafico1", compact('espacio','periodo','alumno','calificacioncuali'),["data1" => json_encode($notasperi1),"data2" => json_encode($notasperi2),"data3" => json_encode($notasperi3),"data4" => json_encode($notasperi4),"añoscolegio" => json_encode($años), "per1" => json_encode($per1),"per2" => json_encode($per2),"per3" => json_encode($per3),"per4" => json_encode($per4),"califi" => json_encode($nombrescalificaciones),"califpromedio" => json_encode($notasprom)]);
        }
        if($periodo=='Trimestre'){
            $notasperiodo1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Primer período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Segundo período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo3 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Tercer período')->orderBy('año','ASC')->pluck("nota");
            $notas1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Primer período')->orderBy('año','ASC')->get();
            $notas2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Segundo período')->orderBy('año','ASC')->get();
            $notas3 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Tercer período')->orderBy('año','ASC')->get();
            $notasperiodo1=[];
            $notasperiodo2=[];
            $notasperiodo3=[];
            $contadoraños=count($años)-1;
            for ($i=0; $i <=$contadoraños; $i++) {
            if(sizeof($notas1)==0){
            $notasperiodo1[$i]=null;
            }
            else{
            foreach ($notas1 as $nota1) {
             if($nota1->año==$idaños[$i]){
                $notasperiodo1[$i]=$nota1->nota;
                break;
            }
            else{
                $notasperiodo1[$i]=null;
            }    
            }
            }      
            if(sizeof($notas2)==0){
            $notasperiodo2[$i]=null;
            }
            else{
            foreach ($notas2 as $nota2) {
             if($nota2->año==$idaños[$i]){
                $notasperiodo2[$i]=$nota2->nota;
                break;
            }    
             else{
                $notasperiodo2[$i]=null;
            }    
            }
            }
            if(sizeof($notas3)==0){
            $notasperiodo3[$i]=null;
            }
            else{
            foreach ($notas3 as $nota3) {
             if($nota3->año==$idaños[$i]){
                $notasperiodo3[$i]=$nota3->nota;
                break;
            }
            else{
                $notasperiodo3[$i]=null;
            }      
            }
            }
            }
            for ($i=0; $i <=$contadoraños; $i++) {
            if(empty($calificacioncuali)){
            $cantidadnotas=0;
            if($notasperiodo1[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo2[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo3[$i]!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas==0){
            $notasprom[$i]=null;
            }
            else{
            $suma=$notasperiodo1[$i]+$notasperiodo2[$i]+$notasperiodo3[$i];
            $notasprom[$i]=$suma/$cantidadnotas;
            }
            }
            else{
            $cantidadnotas=0;
            $puntos1=calificacioncualitativa::where('codigo',$notasperiodo1[$i])->pluck("valor");
            $puntos1 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos1));
            if($puntos1!=null){
                $cantidadnotas++;
            }
            $puntos2=calificacioncualitativa::where('codigo',$notasperiodo2[$i])->pluck("valor");
            $puntos2 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos2));
            if($puntos2!=null){
                $cantidadnotas++;
            }
            $puntos3=calificacioncualitativa::where('codigo',$notasperiodo3[$i])->pluck("valor");
            $puntos3 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos3));
            if($puntos3!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas!=0){ 
            $suma=$puntos1+$puntos2+$puntos3;
            $promedio=$suma/$cantidadnotas;
            if(1<=$promedio and $promedio<=3){
            $calcuali[$i]='NS';
            }
            elseif(3<$promedio and $promedio<=5){
            $calcuali[$i]='S';
            } 
            elseif(5<$promedio and $promedio<=7){
            $calcuali[$i]='B';
            }
            elseif(7<$promedio and $promedio<=9){
            $calcuali[$i]='MB';
            } 
            elseif(9<$promedio){
            $calcuali[$i]='E';
            }
            }
            else{
            $calcuali[$i]=null;    
            }
            }
            }
            $notasperiodo1 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo1);
            $contador1=count($notasperiodo1);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador1 ; $i++) {
            $notasperi1[]=floatval($notasperiodo1[$i]);   
            }
            }
            else{
            $valorcali[]=' ';
            $nombrescalificaciones=array_merge($valorcali,$nombrescalificaciones);
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador1 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo1[$i]==$nombrescali[$j]){
            $notasperi1[$i]=$j;
            break;
            }
            elseif($notasperiodo1[$i]==null){
                $notasperi1[$i]=0;
            }
            }
            }
            for ($i=0; $i <=$contadoraños ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($calcuali[$i]==$nombrescali[$j]){
            $notasprom[]=$j;
            }
            }
            }
            }
            $notasperiodo2 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo2);
            $contador2=count($notasperiodo2);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador2 ; $i++) {
            $notasperi2[]=floatval($notasperiodo2[$i]);   
            }
            }
            else{
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador2 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo2[$i]==$nombrescali[$j]){
            $notasperi2[$i]=$j;
            break;
            }
            elseif($notasperiodo2[$i]==null){
                $notasperi2[$i]=0;
            }
            }
            }
            }
            $notasperiodo3 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo3);
            $contador3=count($notasperiodo3);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador3 ; $i++) {
            $notasperi3[]=floatval($notasperiodo3[$i]);   
            }
            }
            else{
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador3 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo3[$i]==$nombrescali[$j]){
            $notasperi3[$i]=$j;
            break;
            }
            elseif($notasperiodo3[$i]==null){
                $notasperi3[$i]=0;
            }
            }
            }
            }
            $per1='Primer período';
            $per2='Segundo período';
            $per3='Tercer período';
            return view("Graficos.Grafico1", compact('espacio','periodo','alumno','calificacioncuali'),["data1" => json_encode($notasperi1),"data2" => json_encode($notasperi2),"data3" => json_encode($notasperi3),"añoscolegio" => json_encode($años), "per1" => json_encode($per1),"per2" => json_encode($per2),"per3" => json_encode($per3), "califi" => json_encode($nombrescalificaciones),"califpromedio" => json_encode($notasprom)]);
        }
        if($periodo=='Cuatrimestre'){
            $notasperiodo1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Primer período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Segundo período')->orderBy('año','ASC')->pluck("nota");
            $notas1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Primer período')->orderBy('año','ASC')->get();
            $notas2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Segundo período')->orderBy('año','ASC')->get();
            $notasperiodo1=[];
            $notasperiodo2=[];
            $contadoraños=count($años)-1;
            for ($i=0; $i <=$contadoraños; $i++) {
            if(sizeof($notas1)==0){
            $notasperiodo1[$i]=null;
            }
            else{
            foreach ($notas1 as $nota1) {
             if($nota1->año==$idaños[$i]){
                $notasperiodo1[$i]=$nota1->nota;
                break;
            }
            else{
                $notasperiodo1[$i]=null;
            }    
            }
            }
            if(sizeof($notas2)==0){
            $notasperiodo2[$i]=null;
            }
            else{
            foreach ($notas2 as $nota2) {
             if($nota2->año==$idaños[$i]){
                $notasperiodo2[$i]=$nota2->nota;
                 break;
            }    
             else{
                $notasperiodo2[$i]=null;
            }    
            }
            }
            }
            for ($i=0; $i <=$contadoraños; $i++) {
            if(empty($calificacioncuali)){
            $cantidadnotas=0;
            if($notasperiodo1[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo2[$i]!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas==0){
            $notasprom[$i]=null;
            }
            else{
            $suma=$notasperiodo1[$i]+$notasperiodo2[$i]+$notasperiodo3[$i]+$notasperiodo4[$i];
            $notasprom[$i]=$suma/$cantidadnotas;
            }
            }
            else{
            $cantidadnotas=0;
            $puntos1=calificacioncualitativa::where('codigo',$notasperiodo1[$i])->pluck("valor");
            $puntos1 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos1));
            if($puntos1!=null){
                $cantidadnotas++;
            }
            $puntos2=calificacioncualitativa::where('codigo',$notasperiodo2[$i])->pluck("valor");
            $puntos2 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos2));
            if($puntos2!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas!=0){ 
            $suma=$puntos1+$puntos2;
            $promedio=$suma/$cantidadnotas;
            if(1<=$promedio and $promedio<=3){
            $calcuali[$i]='NS';
            }
            elseif(3<$promedio and $promedio<=5){
            $calcuali[$i]='S';
            } 
            elseif(5<$promedio and $promedio<=7){
            $calcuali[$i]='B';
            }
            elseif(7<$promedio and $promedio<=9){
            $calcuali[$i]='MB';
            } 
            elseif(9<$promedio){
            $calcuali[$i]='E';
            }
            }
            else{
            $calcuali[$i]=null;    
            }
            }
            }
            $notasperiodo1 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo1);
            $contador1=count($notasperiodo1);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador1 ; $i++) {
            $notasperi1[]=floatval($notasperiodo1[$i]);   
            }
            }
            else{
            $valorcali[]=' ';
            $nombrescalificaciones=array_merge($valorcali,$nombrescalificaciones);
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador1 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo1[$i]==$nombrescali[$j]){
            $notasperi1[$i]=$j;
            break;
            }
            elseif($notasperiodo1[$i]==null){
                $notasperi1[$i]=0;
            }
            }
            }
            for ($i=0; $i <=$contadoraños ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($calcuali[$i]==$nombrescali[$j]){
            $notasprom[]=$j;
            }
            }
            }
            }
            $notasperiodo2 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo2);
            $contador2=count($notasperiodo2);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador2 ; $i++) {
            $notasperi2[]=floatval($notasperiodo2[$i]);   
            }
            }
            else{
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador2 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo2[$i]==$nombrescali[$j]){
            $notasperi2[$i]=$j;
            break;
            }
            elseif($notasperiodo2[$i]==null){
                $notasperi2[$i]=0;
            }
            }
            }
            }
            $per1='Primer período';
            $per2='Segundo período';
            return view("Graficos.Grafico1", compact('espacio','periodo','alumno','calificacioncuali'),["data1" => json_encode($notasperi1),"data2" => json_encode($notasperi2),"añoscolegio" => json_encode($años), "per1" => json_encode($per1),"per2" => json_encode($per2),"califi" => json_encode($nombrescalificaciones),"califpromedio" => json_encode($notasprom)]);
        }
        if($periodo=='Semestre'){
            $notasperiodo1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Primer período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Segundo período')->orderBy('año','ASC')->pluck("nota");
            $notas1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Primer período')->orderBy('año','ASC')->get();
            $notas2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('espacio',$espacio)->where('periodo','Segundo período')->orderBy('año','ASC')->get();
            $notasperiodo1=[];
            $notasperiodo2=[];
            $contadoraños=count($años)-1;
            for ($i=0; $i <=$contadoraños; $i++) {
            if(sizeof($notas1)==0){
            $notasperiodo1[$i]=null;
            }
            else{
            foreach ($notas1 as $nota1) {
             if($nota1->año==$idaños[$i]){
                $notasperiodo1[$i]=$nota1->nota;
                break;
            }
            else{
                $notasperiodo1[$i]=null;
            }    
            }
            }
            if(sizeof($notas2)==0){
            $notasperiodo2[$i]=null;
            }
            else{
            foreach ($notas2 as $nota2) {
             if($nota2->año==$idaños[$i]){
                $notasperiodo2[$i]=$nota2->nota;
                 break;
            }    
             else{
                $notasperiodo2[$i]=null;
            }    
            }
            }
            }
            for ($i=0; $i <=$contadoraños; $i++) {
            if(empty($calificacioncuali)){
            $cantidadnotas=0;
            if($notasperiodo1[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo2[$i]!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas==0){
            $notasprom[$i]=null;
            }
            else{
            $suma=$notasperiodo1[$i]+$notasperiodo2[$i]+$notasperiodo3[$i]+$notasperiodo4[$i];
            $notasprom[$i]=$suma/$cantidadnotas;
            }
            }
            else{
            $cantidadnotas=0;
            $puntos1=calificacioncualitativa::where('codigo',$notasperiodo1[$i])->pluck("valor");
            $puntos1 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos1));
            if($puntos1!=null){
                $cantidadnotas++;
            }
            $puntos2=calificacioncualitativa::where('codigo',$notasperiodo2[$i])->pluck("valor");
            $puntos2 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos2));
            if($puntos2!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas!=0){ 
            $suma=$puntos1+$puntos2;
            $promedio=$suma/$cantidadnotas;
            if(1<=$promedio and $promedio<=3){
            $calcuali[$i]='NS';
            }
            elseif(3<$promedio and $promedio<=5){
            $calcuali[$i]='S';
            } 
            elseif(5<$promedio and $promedio<=7){
            $calcuali[$i]='B';
            }
            elseif(7<$promedio and $promedio<=9){
            $calcuali[$i]='MB';
            } 
            elseif(9<$promedio){
            $calcuali[$i]='E';
            }
            }
            else{
            $calcuali[$i]=null;    
            }
            }
            }
            $notasperiodo1 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo1);
            $contador1=count($notasperiodo1);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador1 ; $i++) {
            $notasperi1[]=floatval($notasperiodo1[$i]);   
            }
            }
            else{
            $valorcali[]=' ';
            $nombrescalificaciones=array_merge($valorcali,$nombrescalificaciones);
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador1 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo1[$i]==$nombrescali[$j]){
            $notasperi1[$i]=$j;
            break;
            }
            elseif($notasperiodo1[$i]==null){
                $notasperi1[$i]=0;
            }
            }
            }
            for ($i=0; $i <=$contadoraños ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($calcuali[$i]==$nombrescali[$j]){
            $notasprom[]=$j;
            }
            }
            }
            }
            $notasperiodo2 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo2);
            $contador2=count($notasperiodo2);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador2 ; $i++) {
            $notasperi2[]=floatval($notasperiodo2[$i]);   
            }
            }
            else{
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador2 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo2[$i]==$nombrescali[$j]){
            $notasperi2[$i]=$j;
            break;
            }
            elseif($notasperiodo2[$i]==null){
                $notasperi2[$i]=0;
            }
            }
            }
            }
            $per1='Primer período';
            $per2='Segundo período';
            return view("Graficos.Grafico1", compact('espacio','periodo','alumno','calificacioncuali'),["data1" => json_encode($notasperi1),"data2" => json_encode($notasperi2),"añoscolegio" => json_encode($años), "per1" => json_encode($per1),"per2" => json_encode($per2),"califi" => json_encode($nombrescalificaciones),"califpromedio" => json_encode($notasprom)]);
        }
        }
        elseif(empty($request->grado) and empty($request->espacio)){
        $alumno=$request->alumno;
        $nombrealumno=Alumno::where('nombrecompleto',$alumno)->pluck("id");
        $nombrealumno = preg_replace('/[\[\]\.\;\""]+/', '', $nombrealumno);
        $año=$request->añolectivo;
        $idaño=Año::where('descripcion',$año)->pluck("id");
        $idaño = preg_replace('/[\[\]\.\;\""]+/', '', $idaño);
        if($periodo=='Bimestre'){
            $notasperiodo1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Primer período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Segundo período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo3 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Tercer período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo4 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Cuarto período')->orderBy('año','ASC')->pluck("nota");
            $notas1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Primer período')->orderBy('año','ASC')->get();
            $notas2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Segundo período')->orderBy('año','ASC')->get();
            $notas3 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Tercer período')->orderBy('año','ASC')->get();
            $notas4 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Cuarto período')->orderBy('año','ASC')->get();
            $notasperiodo1=[];
            $notasperiodo2=[];
            $notasperiodo3=[];
            $notasperiodo4=[];
            $contadorespacios=count($nombrespacio)-1;
            for ($i=0; $i <=$contadorespacios; $i++) {
            if(sizeof($notas1)==0){
            $notasperiodo1[$i]=null;
            }
            else{
            foreach ($notas1 as $nota1) {
             if($nota1->espacio==$nombrespacio[$i]){
                $notasperiodo1[$i]=$nota1->nota;
                break;
            }
            else{
                $notasperiodo1[$i]=null;
            }    
            }
            }      
            if(sizeof($notas2)==0){
            $notasperiodo2[$i]=null;
            }
            else{
            foreach ($notas2 as $nota2) {
             if($nota2->espacio==$nombrespacio[$i]){
                $notasperiodo2[$i]=$nota2->nota;
                break;
            }    
             else{
                $notasperiodo2[$i]=null;
            }    
            }
            }
            if(sizeof($notas3)==0){
            $notasperiodo3[$i]=null;
            }
            else{
            foreach ($notas3 as $nota3) {
             if($nota3->espacio==$nombrespacio[$i]){
                $notasperiodo3[$i]=$nota3->nota;
                break;
            }
            else{
                $notasperiodo3[$i]=null;
            }      
            }
            }
            if(sizeof($notas4)==0){
            $notasperiodo4[$i]=null;
            }
            else{
            foreach ($notas4 as $nota4) {
             if($nota4->espacio==$nombrespacio[$i]){
                $notasperiodo4[$i]=$nota4->nota;
                break;
            }
            else{
                $notasperiodo4[$i]=null;
            }    
            }
            } 
            }
            for ($i=0; $i <=$contadorespacios; $i++) {
            if(empty($calificacioncuali)){
            $cantidadnotas=0;
            if($notasperiodo1[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo2[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo3[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo4[$i]!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas==0){
            $notasprom[$i]=null;
            }
            else{
            $suma=$notasperiodo1[$i]+$notasperiodo2[$i]+$notasperiodo3[$i]+$notasperiodo4[$i];
            $notasprom[$i]=$suma/$cantidadnotas;
            }
            }
            else{
            $cantidadnotas=0;
            $puntos1=calificacioncualitativa::where('codigo',$notasperiodo1[$i])->pluck("valor");
            $puntos1 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos1));
            if($puntos1!=null){
                $cantidadnotas++;
            }
            $puntos2=calificacioncualitativa::where('codigo',$notasperiodo2[$i])->pluck("valor");
            $puntos2 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos2));
            if($puntos2!=null){
                $cantidadnotas++;
            }
            $puntos3=calificacioncualitativa::where('codigo',$notasperiodo3[$i])->pluck("valor");
            $puntos3 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos3));
            if($puntos3!=null){
                $cantidadnotas++;
            }
            $puntos4=calificacioncualitativa::where('codigo',$notasperiodo4[$i])->pluck("valor");
            $puntos4 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos4));
            if($puntos4!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas!=0){ 
            $suma=$puntos1+$puntos2+$puntos3+$puntos4;
            $promedio=$suma/$cantidadnotas;
            if(1<=$promedio and $promedio<=3){
            $calcuali[$i]='NS';
            }
            elseif(3<$promedio and $promedio<=5){
            $calcuali[$i]='S';
            } 
            elseif(5<$promedio and $promedio<=7){
            $calcuali[$i]='B';
            }
            elseif(7<$promedio and $promedio<=9){
            $calcuali[$i]='MB';
            } 
            elseif(9<$promedio){
            $calcuali[$i]='E';
            }
            }
            else{
            $calcuali[$i]=null;    
            }
            }
            }
            $notasperiodo1 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo1);
            $contador1=count($notasperiodo1);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador1 ; $i++) {
            $notasperi1[]=floatval($notasperiodo1[$i]);   
            }
            }
            else{
            $valorcali[]=' ';
            $nombrescalificaciones=array_merge($valorcali,$nombrescalificaciones);
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador1 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo1[$i]==$nombrescali[$j]){
            $notasperi1[]=$j;
            }
            elseif($notasperiodo1[$i]==null){
                $notasperi1[$i]=0;
            }
            }
            }
            for ($i=0; $i <=$contadorespacios ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($calcuali[$i]==$nombrescali[$j]){
            $notasprom[]=$j;
            }
            }
            }
            }
            $notasperiodo2 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo2);
            $contador2=count($notasperiodo2);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador2 ; $i++) {
            $notasperi2[]=floatval($notasperiodo2[$i]);   
            }
            }
            else{
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador2 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo2[$i]==$nombrescali[$j]){
            $notasperi2[$i]=$j;
            }
            elseif($notasperiodo2[$i]==null){
                $notasperi2[$i]=0;
            }
            }
            }
            }
            $notasperiodo3 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo3);
            $contador3=count($notasperiodo3);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador3 ; $i++) {
            $notasperi3[]=floatval($notasperiodo3[$i]);   
            }
            }
            else{
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador3 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo3[$i]==$nombrescali[$j]){
            $notasperi3[]=$j;
            }
            elseif($notasperiodo3[$i]==null){
                $notasperi3[$i]=0;
            }
            }
            }
            }
            $notasperiodo4 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo4);
            $contador4=count($notasperiodo4);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador4 ; $i++) {
            $notasperi4[]=floatval($notasperiodo4[$i]);   
            }
            }
            else{
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador4 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo4[$i]==$nombrescali[$j]){
            $notasperi4[$i]=$j;
            }
            elseif($notasperiodo4[$i]==null){
                $notasperi4[$i]=0;
            }
            }
            }
            }
            $per1='Primer período';
            $per2='Segundo período';
            $per3='Tercer período';
            $per4='Cuarto período';
            return view("Graficos.Grafico2", compact('año','periodo','alumno','calificacioncuali'),["data1" => json_encode($notasperi1),"data2" => json_encode($notasperi2),"data3" => json_encode($notasperi3),"data4" => json_encode($notasperi4),"nombrespacios" => json_encode($nombrespacio), "per1" => json_encode($per1),"per2" => json_encode($per2),"per3" => json_encode($per3),"per4" => json_encode($per4) "califi" => json_encode($nombrescalificaciones),"califpromedio" => json_encode($notasprom)]);
        }
        if($periodo=='Trimestre'){
            $notasperiodo1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Primer período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Segundo período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo3 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Tercer período')->orderBy('año','ASC')->pluck("nota");
            $notas1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Primer período')->orderBy('año','ASC')->get();
            $notas2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Segundo período')->orderBy('año','ASC')->get();
            $notas3 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Tercer período')->orderBy('año','ASC')->get();
            $notasperiodo1=[];
            $notasperiodo2=[];
            $notasperiodo3=[];
            $contadorespacios=count($nombrespacio)-1;
            for ($i=0; $i <=$contadorespacios; $i++) {
            if(sizeof($notas1)==0){
            $notasperiodo1[$i]=null;
            }
            else{
            foreach ($notas1 as $nota1) {
             if($nota1->espacio==$nombrespacio[$i]){
                $notasperiodo1[$i]=$nota1->nota;
                break;
            }
            else{
                $notasperiodo1[$i]=null;
            }    
            }
            }      
            if(sizeof($notas2)==0){
            $notasperiodo2[$i]=null;
            }
            else{
            foreach ($notas2 as $nota2) {
             if($nota2->espacio==$nombrespacio[$i]){
                $notasperiodo2[$i]=$nota2->nota;
                break;
            }    
             else{
                $notasperiodo2[$i]=null;
            }    
            }
            }
            if(sizeof($notas3)==0){
            $notasperiodo3[$i]=null;
            }
            else{
            foreach ($notas3 as $nota3) {
             if($nota3->espacio==$nombrespacio[$i]){
                $notasperiodo3[$i]=$nota3->nota;
                break;
            }
            else{
                $notasperiodo3[$i]=null;
            }      
            }
            }
            }
            for ($i=0; $i <=$contadorespacios; $i++) {
            if(empty($calificacioncuali)){
            $cantidadnotas=0;
            if($notasperiodo1[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo2[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo3[$i]!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas==0){
            $notasprom[$i]=null;
            }
            else{
            $suma=$notasperiodo1[$i]+$notasperiodo2[$i]+$notasperiodo3[$i];
            $notasprom[$i]=$suma/$cantidadnotas;
            }
            }
            else{
            $cantidadnotas=0;
            $puntos1=calificacioncualitativa::where('codigo',$notasperiodo1[$i])->pluck("valor");
            $puntos1 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos1));
            if($puntos1!=null){
                $cantidadnotas++;
            }
            $puntos2=calificacioncualitativa::where('codigo',$notasperiodo2[$i])->pluck("valor");
            $puntos2 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos2));
            if($puntos2!=null){
                $cantidadnotas++;
            }
            $puntos3=calificacioncualitativa::where('codigo',$notasperiodo3[$i])->pluck("valor");
            $puntos3 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos3));
            if($puntos3!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas!=0){ 
            $suma=$puntos1+$puntos2+$puntos3;
            $promedio=$suma/$cantidadnotas;
            if(1<=$promedio and $promedio<=3){
            $calcuali[$i]='NS';
            }
            elseif(3<$promedio and $promedio<=5){
            $calcuali[$i]='S';
            } 
            elseif(5<$promedio and $promedio<=7){
            $calcuali[$i]='B';
            }
            elseif(7<$promedio and $promedio<=9){
            $calcuali[$i]='MB';
            } 
            elseif(9<$promedio){
            $calcuali[$i]='E';
            }
            }
            else{
            $calcuali[$i]=null;    
            }
            }
            }
            $notasperiodo1 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo1);
            $contador1=count($notasperiodo1);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador1 ; $i++) {
            $notasperi1[]=floatval($notasperiodo1[$i]);   
            }
            }
            else{
            $valorcali[]=' ';
            $nombrescalificaciones=array_merge($valorcali,$nombrescalificaciones);
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador1 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo1[$i]==$nombrescali[$j]){
            $notasperi1[]=$j;
            }
            elseif($notasperiodo1[$i]==null){
                $notasperi1[$i]=0;
            }
            }
            }
            for ($i=0; $i <=$contadorespacios ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($calcuali[$i]==$nombrescali[$j]){
            $notasprom[]=$j;
            }
            }
            }
            }
            $notasperiodo2 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo2);
            $contador2=count($notasperiodo2);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador2 ; $i++) {
            $notasperi2[]=floatval($notasperiodo2[$i]);   
            }
            }
            else{
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador2 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo2[$i]==$nombrescali[$j]){
            $notasperi2[$i]=$j;
            }
            elseif($notasperiodo2[$i]==null){
                $notasperi2[$i]=0;
            }
            }
            }
            }
            $notasperiodo3 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo3);
            $contador3=count($notasperiodo3);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador3 ; $i++) {
            $notasperi3[]=floatval($notasperiodo3[$i]);   
            }
            }
            else{
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador3 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo3[$i]==$nombrescali[$j]){
            $notasperi3[]=$j;
            }
            elseif($notasperiodo3[$i]==null){
                $notasperi3[$i]=0;
            }
            }
            }
            }
            $per1='Primer período';
            $per2='Segundo período';
            $per3='Tercer período';
            return view("Graficos.Grafico2", compact('año','periodo','alumno','calificacioncuali'),["data1" => json_encode($notasperi1),"data2" => json_encode($notasperi2),"data3" => json_encode($notasperi3),"nombrespacios" => json_encode($nombrespacio), "per1" => json_encode($per1),"per2" => json_encode($per2),"per3" => json_encode($per3), "califi" => json_encode($nombrescalificaciones),"califpromedio" => json_encode($notasprom)]);
        } 
        if($periodo=='Cuatrimestre'){
            $notasperiodo1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Primer período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Segundo período')->orderBy('año','ASC')->pluck("nota");
            $notas1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Primer período')->orderBy('año','ASC')->get();
            $notas2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Segundo período')->orderBy('año','ASC')->get();
            $notasperiodo1=[];
            $notasperiodo2=[];
            $contadorespacios=count($nombrespacio)-1;
            for ($i=0; $i <=$contadorespacios; $i++) {
            if(sizeof($notas1)==0){
            $notasperiodo1[$i]=null;
            }
            else{
            foreach ($notas1 as $nota1) {
             if($nota1->espacio==$nombrespacio[$i]){
                $notasperiodo1[$i]=$nota1->nota;
                break;
            }
            else{
                $notasperiodo1[$i]=null;
            }    
            }
            }      
            if(sizeof($notas2)==0){
            $notasperiodo2[$i]=null;
            }
            else{
            foreach ($notas2 as $nota2) {
             if($nota2->espacio==$nombrespacio[$i]){
                $notasperiodo2[$i]=$nota2->nota;
                break;
            }    
             else{
                $notasperiodo2[$i]=null;
            }    
            }
            }
            }
            for ($i=0; $i <=$contadorespacios; $i++) {
            if(empty($calificacioncuali)){
            $cantidadnotas=0;
            if($notasperiodo1[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo2[$i]!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas==0){
            $notasprom[$i]=null;
            }
            else{
            $suma=$notasperiodo1[$i]+$notasperiodo2[$i];
            $notasprom[$i]=$suma/$cantidadnotas;
            }
            }
            else{
            $cantidadnotas=0;
            $puntos1=calificacioncualitativa::where('codigo',$notasperiodo1[$i])->pluck("valor");
            $puntos1 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos1));
            if($puntos1!=null){
                $cantidadnotas++;
            }
            $puntos2=calificacioncualitativa::where('codigo',$notasperiodo2[$i])->pluck("valor");
            $puntos2 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos2));
            if($puntos2!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas!=0){ 
            $suma=$puntos1+$puntos2;
            $promedio=$suma/$cantidadnotas;
            if(1<=$promedio and $promedio<=3){
            $calcuali[$i]='NS';
            }
            elseif(3<$promedio and $promedio<=5){
            $calcuali[$i]='S';
            } 
            elseif(5<$promedio and $promedio<=7){
            $calcuali[$i]='B';
            }
            elseif(7<$promedio and $promedio<=9){
            $calcuali[$i]='MB';
            } 
            elseif(9<$promedio){
            $calcuali[$i]='E';
            }
            }
            else{
            $calcuali[$i]=null;    
            }
            }
            }
            $notasperiodo1 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo1);
            $contador1=count($notasperiodo1);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador1 ; $i++) {
            $notasperi1[]=floatval($notasperiodo1[$i]);   
            }
            }
            else{
            $valorcali[]=' ';
            $nombrescalificaciones=array_merge($valorcali,$nombrescalificaciones);
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador1 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo1[$i]==$nombrescali[$j]){
            $notasperi1[]=$j;
            }
            elseif($notasperiodo1[$i]==null){
                $notasperi1[$i]=0;
            }
            }
            }
            for ($i=0; $i <=$contadorespacios ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($calcuali[$i]==$nombrescali[$j]){
            $notasprom[]=$j;
            }
            }
            }
            }
            $notasperiodo2 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo2);
            $contador2=count($notasperiodo2);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador2 ; $i++) {
            $notasperi2[]=floatval($notasperiodo2[$i]);   
            }
            }
            else{
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador2 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo2[$i]==$nombrescali[$j]){
            $notasperi2[$i]=$j;
            }
            elseif($notasperiodo2[$i]==null){
                $notasperi2[$i]=0;
            }
            }
            }
            }
            $per1='Primer período';
            $per2='Segundo período';
            return view("Graficos.Grafico2", compact('año','periodo','alumno','calificacioncuali'),["data1" => json_encode($notasperi1),"data2" => json_encode($notasperi2),"nombrespacios" => json_encode($nombrespacio), "per1" => json_encode($per1),"per2" => json_encode($per2), "califi" => json_encode($nombrescalificaciones),"califpromedio" => json_encode($notasprom)]);
        } 
        if($periodo=='Semestre'){
            $notasperiodo1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Primer período')->orderBy('año','ASC')->pluck("nota");
            $notasperiodo2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Segundo período')->orderBy('año','ASC')->pluck("nota");
            $notas1 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Primer período')->orderBy('año','ASC')->get();
            $notas2 = Informes::where('colegio_id',$idcolegio)->where('id_alumno',$nombrealumno)->where('año',$idaño)->where('periodo','Segundo período')->orderBy('año','ASC')->get();
            $notasperiodo1=[];
            $notasperiodo2=[];
            $contadorespacios=count($nombrespacio)-1;
            for ($i=0; $i <=$contadorespacios; $i++) {
            if(sizeof($notas1)==0){
            $notasperiodo1[$i]=null;
            }
            else{
            foreach ($notas1 as $nota1) {
             if($nota1->espacio==$nombrespacio[$i]){
                $notasperiodo1[$i]=$nota1->nota;
                break;
            }
            else{
                $notasperiodo1[$i]=null;
            }    
            }
            }      
            if(sizeof($notas2)==0){
            $notasperiodo2[$i]=null;
            }
            else{
            foreach ($notas2 as $nota2) {
             if($nota2->espacio==$nombrespacio[$i]){
                $notasperiodo2[$i]=$nota2->nota;
                break;
            }    
             else{
                $notasperiodo2[$i]=null;
            }    
            }
            }
            }
            for ($i=0; $i <=$contadorespacios; $i++) {
            if(empty($calificacioncuali)){
            $cantidadnotas=0;
            if($notasperiodo1[$i]!=null){
                $cantidadnotas++;
            }
            if($notasperiodo2[$i]!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas==0){
            $notasprom[$i]=null;
            }
            else{
            $suma=$notasperiodo1[$i]+$notasperiodo2[$i];
            $notasprom[$i]=$suma/$cantidadnotas;
            }
            }
            else{
            $cantidadnotas=0;
            $puntos1=calificacioncualitativa::where('codigo',$notasperiodo1[$i])->pluck("valor");
            $puntos1 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos1));
            if($puntos1!=null){
                $cantidadnotas++;
            }
            $puntos2=calificacioncualitativa::where('codigo',$notasperiodo2[$i])->pluck("valor");
            $puntos2 = floatval(preg_replace('/[\[\]\\;\""]+/', '', $puntos2));
            if($puntos2!=null){
                $cantidadnotas++;
            }
            if($cantidadnotas!=0){ 
            $suma=$puntos1+$puntos2;
            $promedio=$suma/$cantidadnotas;
            if(1<=$promedio and $promedio<=3){
            $calcuali[$i]='NS';
            }
            elseif(3<$promedio and $promedio<=5){
            $calcuali[$i]='S';
            } 
            elseif(5<$promedio and $promedio<=7){
            $calcuali[$i]='B';
            }
            elseif(7<$promedio and $promedio<=9){
            $calcuali[$i]='MB';
            } 
            elseif(9<$promedio){
            $calcuali[$i]='E';
            }
            }
            else{
            $calcuali[$i]=null;    
            }
            }
            }
            $notasperiodo1 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo1);
            $contador1=count($notasperiodo1);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador1 ; $i++) {
            $notasperi1[]=floatval($notasperiodo1[$i]);   
            }
            }
            else{
            $valorcali[]=' ';
            $nombrescalificaciones=array_merge($valorcali,$nombrescalificaciones);
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador1 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo1[$i]==$nombrescali[$j]){
            $notasperi1[]=$j;
            }
            elseif($notasperiodo1[$i]==null){
                $notasperi1[$i]=0;
            }
            }
            }
            for ($i=0; $i <=$contadorespacios ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($calcuali[$i]==$nombrescali[$j]){
            $notasprom[]=$j;
            }
            }
            }
            }
            $notasperiodo2 = preg_replace('/[\[\]\.\;\""]+/', '', $notasperiodo2);
            $contador2=count($notasperiodo2);
            if(empty($calificacioncuali)){
            for ($i=0; $i <$contador2 ; $i++) {
            $notasperi2[]=floatval($notasperiodo2[$i]);   
            }
            }
            else{
            $nombrescali = preg_replace('/[\[\]\.\;\""]+/', '', $nombrescalificaciones);
            $contadorcuali=count($nombrescalificaciones)-1;
            for ($i=0; $i <$contador2 ; $i++) {
            for ($j=0; $j <=$contadorcuali ; $j++) {
            if($notasperiodo2[$i]==$nombrescali[$j]){
            $notasperi2[$i]=$j;
            }
            elseif($notasperiodo2[$i]==null){
                $notasperi2[$i]=0;
            }
            }
            }
            }
            $per1='Primer período';
            $per2='Segundo período';
            return view("Graficos.Grafico2", compact('año','periodo','alumno','calificacioncuali'),["data1" => json_encode($notasperi1),"data2" => json_encode($notasperi2),"nombrespacios" => json_encode($nombrespacio), "per1" => json_encode($per1),"per2" => json_encode($per2), "califi" => json_encode($nombrescalificaciones),"califpromedio" => json_encode($notasprom)]);
        }         

        }
    }
}