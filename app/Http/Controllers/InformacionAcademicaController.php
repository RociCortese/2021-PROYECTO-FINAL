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
}