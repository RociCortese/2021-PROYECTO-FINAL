<?php

namespace App\Http\Controllers;

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

    public function index()
   {
    $idpersona= Auth::user()->idpersona;
    $idusuario= Auth::user()->id;
    $tipodocente=Docente::where('id',$idpersona)->get();
    foreach($tipodocente as $tipo){
        $tipodoc="$tipo->especialidad";
    }
    if($tipodoc=='Grado'){
    $datoscriterio= CriteriosEvaluacion::where('id_usuario',$idusuario)->orderby('id_espacio','ASC')->paginate(5);
    }
    if($tipodoc!='Grado'){
    $datoscriterio= CriteriosEvaluacion::where('id_usuario',$idusuario)->orderby('id','ASC')->paginate(5);
    }
    return view('Criterios/index',compact('datoscriterio','tipodoc'));
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
        $infocol = preg_replace('/[\[\]\.\;\" "]+/', '', $infocol);
        $infocol=explode(',', $infocol);
        $contador=count($infocol)-1;
        for ($i=0; $i <= $contador ; $i++) { 
        $nombreespacios[]=espacioscurriculares::where('id',$infocol[$i])->pluck("nombre");
        }
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
            'añoescolar' => ['required'],
            'espaciocurricular' => ['required'],
        ]);
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$request->añoescolar;
        $nuevocriterio->id_espacio=$request->espaciocurricular;
        $nuevocriterio->save();        
        return redirect()->route('criteriosevaluacion')->with('success', 'El criterio de evaluación se cargó correctamente.');
        }
         if($tipodoc!='Grado'){
         $request->validate([
            'criterio' => ['required','max:50'],
            'ponderacion' => ['required','int'],
            'descripcion' => ['max:150'],
            'añoescolar' => ['required'],
            'grado' => ['required'],
        ]);
        $nuevocriterio=new CriteriosEvaluacion();
        $nuevocriterio->criterio=$request->criterio;
        $nuevocriterio->ponderacion=$request->ponderacion;
        $nuevocriterio->descripcion=$request->descripcion;
        $nuevocriterio->id_usuario=Auth::user()->id;
        $nuevocriterio->id_año=$request->añoescolar;
        $nuevocriterio->id_grado=$request->grado;
        $nuevocriterio->save();        
        return redirect()->route('criteriosevaluacion')->with('success', 'El criterio de evaluación se cargó correctamente.');
        }


    } 
}
