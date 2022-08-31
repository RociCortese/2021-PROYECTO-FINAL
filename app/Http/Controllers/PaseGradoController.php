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
use App\Models\NotaFinal;

class PaseGradoController extends Controller
{
    public function __construct()
   {
    $this->middleware('auth');
   }
    public function buscador(Request $request)
    {
    $idcolegio=Auth::user()->colegio_id;
    $años=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->orderBy('descripcion','ASC')->pluck("descripcion");
    $años = preg_replace('/[\[\]\.\;\" "]+/', '', $años);
    $grados=Grado::where('colegio_id',$idcolegio)->get();
    $grado=$grados->unique('descripcion');
    foreach($grado as $infogrado){
        $informaciongrado[]="$infogrado->descripcion";
    }
    return view('PaseGrado.buscador',compact('años','informaciongrado'));
    }
    public function index(Request $request)
    {
    $idcolegio=Auth::user()->colegio_id;
    $infgrado = trim($request->get('grado'));
    $años=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->orderBy('descripcion','ASC')->pluck("descripcion");
    $años = preg_replace('/[\[\]\.\;\" "]+/', '', $años);
    $idaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->orderBy('descripcion','ASC')->pluck("id");
    $grados=Grado::where('colegio_id',$idcolegio)->get();
    $grado=$grados->unique('descripcion');
    foreach($grado as $infogrado){
        $informaciongrado[]="$infogrado->descripcion";
    }
    $notasfinales=NotaFinal::where('grado',$infgrado)->where('colegio_id',$idcolegio)->where('año',$idaño)->paginate(10);
    $notasunica=NotaFinal::where('grado',$infgrado)->where('colegio_id',$idcolegio)->where('año',$idaño)->get();
    $notasunica=$notasunica->unique('id_alumno');
    return view('PaseGrado.index',compact('notasfinales','años','informaciongrado','infgrado','notasunica'));
    }

    public function pasedegrado($id_alumno){
    $infoalumno=Alumno::where('id',$id_alumno)->pluck("grado");
    $grado = preg_replace('/[\[\]\.\;\""]+/', '', $infoalumno);
    $ultimocaracter=substr($grado, -1);
    if(strpos($grado,'Primer grado')!== false){
    $numerogrado=1;
    }
    if(strpos($grado,'Segundo grado')!== false){
    $numerogrado=2;
    }
    if(strpos($grado,'Tercer grado')!== false){
    $numerogrado=3;
    }
    if(strpos($grado,'Cuarto grado')!== false){
    $numerogrado=4;
    }
    if(strpos($grado,'Quinto grado')!== false){
    $numerogrado=5;
    }
    if(strpos($grado,'Sexto grado')!== false){
    $numerogrado=6;
    }
    if(strpos($grado,'Séptimo grado')!== false){
    $numerogrado=7;
    }
    $informacionalumno=Alumno::where('id',$id_alumno)->first();
    $sumatotal=$numerogrado+1;
    if($sumatotal==2){
    $informacionalumno->grado='Segundo grado'.' '. $ultimocaracter;
    }
    if($sumatotal==3){
    $informacionalumno->grado='Tercer grado'.' '. $ultimocaracter;
    }
    if($sumatotal==4){
    $informacionalumno->grado='Cuarto grado'.' '. $ultimocaracter;
    }
    if($sumatotal==5){
    $informacionalumno->grado='Quinto grado'.' '. $ultimocaracter;
    }
    if($sumatotal==6){
    $informacionalumno->grado='Sexto grado'.' '. $ultimocaracter;
    }
    if($sumatotal==7){
    $informacionalumno->grado='Séptimo grado'.' '. $ultimocaracter;
    }
    $informacionalumno->save(); 
    return redirect()->back()->with('success', 'Se ha realizado correctamente el pase de grado.');
}
public function pasartodos(Request $request){
    $idcolegio=Auth::user()->colegio_id;
    $infgrado = trim($request->get('grado'));
    $años=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->orderBy('descripcion','ASC')->pluck("descripcion");
    $años = preg_replace('/[\[\]\.\;\" "]+/', '', $años);
    $idaño=Año::where('id_colegio',$idcolegio)->where('estado','=','activo')->orderBy('descripcion','ASC')->pluck("id");
    $notasfinales=NotaFinal::where('grado',$infgrado)->where('colegio_id',$idcolegio)->where('año',$idaño)->get();
    foreach($notasfinales as $alumnos){
       $idalumnos[]="$alumnos->id_alumno"; 
    }
    $contadoralumnos=count($idalumnos)-1;
    for ($i=0; $i <=$contadoralumnos ; $i++) {
    $infoalumno=Alumno::where('id',$idalumnos[$i])->pluck("grado"); 
    $grado = preg_replace('/[\[\]\.\;\""]+/', '', $infoalumno);
    $ultimocaracter=substr($grado, -1);
    if(strpos($grado,'Primer grado')!== false){
    $numerogrado=1;
    }
    if(strpos($grado,'Segundo grado')!== false){
    $numerogrado=2;
    }
    if(strpos($grado,'Tercer grado')!== false){
    $numerogrado=3;
    }
    if(strpos($grado,'Cuarto grado')!== false){
    $numerogrado=4;
    }
    if(strpos($grado,'Quinto grado')!== false){
    $numerogrado=5;
    }
    if(strpos($grado,'Sexto grado')!== false){
    $numerogrado=6;
    }
    if(strpos($grado,'Séptimo grado')!== false){
    $numerogrado=7;
    }
    $informacionalumno=Alumno::where('id',$idalumnos[$i])->first();
    $sumatotal=$numerogrado+1;
    if($sumatotal==2){
    $informacionalumno->grado='Segundo grado'.' '. $ultimocaracter;
    }
    if($sumatotal==3){
    $informacionalumno->grado='Tercer grado'.' '. $ultimocaracter;
    }
    if($sumatotal==4){
    $informacionalumno->grado='Cuarto grado'.' '. $ultimocaracter;
    }
    if($sumatotal==5){
    $informacionalumno->grado='Quinto grado'.' '. $ultimocaracter;
    }
    if($sumatotal==6){
    $informacionalumno->grado='Sexto grado'.' '. $ultimocaracter;
    }
    if($sumatotal==7){
    $informacionalumno->grado='Séptimo grado'.' '. $ultimocaracter;
    }
    $informacionalumno->save(); 
    }
     return redirect()->back()->with('success', 'Se ha realizado correctamente el pase de grado.');
}
}