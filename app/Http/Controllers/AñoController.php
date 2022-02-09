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
use App\Models\Abecedario;

class AñoController extends Controller
{
    public function __construct()
   {
    $this->middleware('auth');
   }

    public function index()
   {
    $idpersona=Auth::user()->id;
    $colegio= Colegio::all()->where('users_id',$idpersona);
    foreach ($colegio as $idcol) {
    $idcolegio="$idcol->id";
    $periodocolegio="$idcol->periodo";
    }
    if($colegio->isEmpty())
        {
            return view('añoescolar.listado',compact('colegio'));
        }
    elseif(empty($periodocolegio))
        {
            return view('añoescolar.listado',compact('periodocolegio','colegio'));
        }
    else{
    $años = Año::orderBy('estado','ASC')->where('id_colegio',$idcolegio)->paginate(5);
    return view('añoescolar.listado',compact('años','periodocolegio','colegio'));
    }
   }
    public function create(Request $request)
    {
      $idpersona=Auth::user()->id;
      $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $idcolegio="$idcol->id";
          $periodocolegio="$idcol->periodo";
        }
        return view('añoescolar.create',compact('periodocolegio'));
    }
    public function store(Request $request)
    {
      $idpersona=Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $idcolegio="$idcol->id";
          $periodocolegio="$idcol->periodo";
        }
        if($periodocolegio=='Bimestre'){
         $request->validate([
            'descripcion' => ['required', 'int','unique:año'],
            'fechainicio' => ['required','date("Y",fechainicio):descripcion'],
            'fechafin' => ['required','after_or_equal:fechainicio'],
            'inicioperiodo1' =>['required','date_equals:fechainicio'],
            'finperiodo1' =>'required',
            'inicioperiodo2' =>['required','after_or_equal:finperiodo1'],
            'finperiodo2' =>'required',
            'inicioperiodo3' =>['required','after_or_equal:finperiodo2'],
            'finperiodo3' =>'required',
            'inicioperiodo4' =>['required','after_or_equal:finperiodo3'],
            'finperiodo4' =>['required','date_equals:fechafin'],
        ]);}
         if($periodocolegio=='Trimestre'){
         $request->validate([
            'descripcion' => ['required', 'int','unique:año'],
            'fechainicio' => 'required',
            'fechafin' => ['required','after_or_equal:fechainicio'],
            'inicioperiodo1' =>['required','date_equals:fechainicio'],
            'finperiodo1' =>'required',
            'inicioperiodo2' =>['required','after_or_equal:finperiodo1'],
            'finperiodo2' =>'required',
            'inicioperiodo3' =>['required','after_or_equal:finperiodo2'],
            'finperiodo3' =>['required','date_equals:fechafin'],
        ]);}
         if($periodocolegio=='Cuatrimestre'){
         $request->validate([
            'descripcion' => ['required', 'int','unique:año'],
            'fechainicio' => 'required',
            'fechafin' => ['required','after_or_equal:fechainicio'],
            'inicioperiodo1' =>['required','date_equals:fechainicio'],
            'finperiodo1' =>'required',
            'inicioperiodo2' =>['required','after_or_equal:finperiodo1'],
            'finperiodo2' =>['required','date_equals:fechafin'],
        ]);}
         if($periodocolegio=='Semestre'){
         $request->validate([
            'descripcion' => ['required', 'int','unique:año'],
            'fechainicio' => ['required'],
            'fechafin' => ['required','after_or_equal:fechainicio'],
            'inicioperiodo1' =>['required','date_equals:fechainicio'],
            'finperiodo1' =>'required',
            'inicioperiodo2' =>['required','after_or_equal:finperiodo1'],
            'finperiodo2' =>['required','date_equals:fechafin'],
        ]);}
        $año=new Año();
        $año->descripcion=$request->descripcion;
        $descri=$año->descripcion;
        $año->fechainicio=$request->fechainicio;
        $año->fechafin=$request->fechafin;
        $año->estado='inactivo';
        $año->inicioperiodo1=$request->inicioperiodo1;
        $año->finperiodo1=$request->finperiodo1;
        $año->inicioperiodo2=$request->inicioperiodo2;
        $año->finperiodo2=$request->finperiodo2;
        $año->inicioperiodo3=$request->inicioperiodo3;
        $año->finperiodo3=$request->finperiodo3;
        $año->inicioperiodo4=$request->inicioperiodo4;
        $año->finperiodo4=$request->finperiodo4;
        $año->id_colegio=$idcolegio;
        $año->save();   
         $años = Año::orderBy('estado','ASC')->where('id_colegio',$idcolegio)->paginate(5);
         return redirect()->route('añoescolar',compact('descri','periodocolegio','años','colegio'))->with('success','El año escolar se creo correctamente.');
    } 

    public function listadogrado(Request $request)
    {
      $idpersona=Auth::user()->id;
      $colegio= Colegio::all()->where('users_id',$idpersona);
      foreach ($colegio as $idcol) {
        $idcolegio="$idcol->id";
      }
      if($colegio->isEmpty())
        {
            return view('añoescolar.listadogrado',compact('colegio'));
        }
      else{
      /*Busca el id de los años que están activos y pertenecen al colegio que se encuentra logueado*/
      $estado= Año::where('estado','activo')->where('id_colegio',$idcolegio)->get();

      /*Busca todos los años que pertenecen al colegio que se encuentra logueado*/
      $todoestado= Año::where('id_colegio',$idcolegio)->orderBy('descripcion','ASC')->get();
      foreach ($todoestado as $todoest) {
      $todoesta="$todoest->id";
    }
      if($todoestado->isEmpty())
        {
            return view('añoescolar.listadogrado',compact('todoestado','colegio'));
        }
      else{
      foreach ($estado as $idaño) {
        $idest="$idaño->id";
        $descripcionselect="$idaño->descripcion";
        $estadoselect="$idaño->estado";
      }
      foreach ($estado as $idaños) {
        $descripcionaño="$idaños->descripcion";
      }
      $docentesespe= Docente::all()->sortBy('nombredocente')->where('especialidad','!=','Grado')->where('colegio_id',$idcolegio);
      /*Busca todos los grados que están relacionados con el año activo y los ordena*/
      if(empty($idest)){
        $descripcionaño=" ";
        $descripcionselect=" ";
        $estadoselect=" "; 
        $grado = Grado::where('id_anio',$todoesta)->orderBy('num_grado','ASC')->get();
        return view('añoescolar.listadogrado',compact('todoestado','docentesespe','colegio','estado','descripcionaño','descripcionselect','estadoselect','grado'));
      }
      else{
      $grado = Grado::where('id_anio',$idest)->orderBy('num_grado','ASC')->get();                                           
      return view('añoescolar.listadogrado',compact('grado','todoestado','docentesespe','descripcionselect','colegio','estadoselect','descripcionaño','estado'));
    }
          }
        }
    }
    public function buscar(Request $request){
      $añoseleccionado = $request->get('buscaraño') ;
      $select=Año::where('descripcion','LIKE',"%$añoseleccionado%")->get();
      foreach ($select as $selectaño) {
        $idselect="$selectaño->id";
        $descripcionselect="$selectaño->descripcion";
        $estadoselect="$selectaño->estado";
      }
       $idpersona=Auth::user()->id;
      $colegio= Colegio::all()->where('users_id',$idpersona);
      foreach ($colegio as $idcol) {
        $idcolegio="$idcol->id";
      }
      $todoestado= Año::where('id_colegio',$idcolegio)->orderBy('descripcion','ASC')->get();
      $estado= Año::where('estado','activo')->where('id_colegio',$idcolegio)->get();

      /*Busca todos los años que pertenecen al colegio que se encuentra logueado*/
      $todoestado= Año::where('id_colegio',$idcolegio)->orderBy('descripcion','ASC')->get();
      if($todoestado->isEmpty())
        {
            return view('añoescolar.listadogrado',compact('todoestado','colegio','descripcionselect'));
        }
      else{
      foreach ($estado as $idaño) {
        $idest="$idaño->id";
        $descripcionaño="$idaño->descripcion";
      }
      foreach ($todoestado as $todoest) {
      $todoesta="$todoest->id";
    }
    }
    $docentesespe= Docente::all()->sortBy('nombredocente')->where('especialidad','!=','Grado')->where('colegio_id',$idcolegio);
    $grado = Grado::where('id_anio',$idselect)->orderBy('num_grado','ASC')->get();
    if(empty($idest)){
    $descripcionaño=" ";
  }
      return view('añoescolar.listadogrado',compact('grado','todoestado','docentesespe','descripcionselect','colegio','estadoselect','descripcionaño','estado'));
    }


    public function creategrado(Request $request)
    {
      /*Busca el id del colegio que se encuentra logueado*/
      $idpersona=Auth::user()->id;
      $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $idcolegio="$idcol->id";
        }
      /*Busca todos los docentes cuya especialidad es grado*/
      $docentes= Docente::all()->sortBy('nombredocente')->where('especialidad','Grado')->where('colegio_id',$idcolegio);

      
        $maxgrado=Colegio::where('id',$idcolegio)->get();
        foreach ($maxgrado as $max) {
            $maximogrado="$max->grados";
        }

      /*Busca todos los años que pertenecen al id del colegio que se encuentra logueado*/
      $año=Año::where('id_colegio',$idcolegio)->where('estado','!=','cerrado')->orderBy('descripcion','ASC')->get();
      $division=Colegio::where('id',$idcolegio)->get();
        foreach ($division as $div) {
            $divcol="$div->divisiones";
        }
        $res = preg_replace('/[\[\]\.\;\" "]+/', '', $divcol);
        $divcol=explode(',', $res);
        $contador=count($divcol)-1;
        for ($i=0; $i <= $contador ; $i++) { 
        $nombredivision[]=Abecedario::where('id',$divcol[$i])->pluck("letras");
        }

      return view('añoescolar.creategrado',compact('docentes','año','maximogrado','nombredivision'));
    }

    public function armadogrado(Request $request)
    {
      $añoseleccionado = $request->get('buscaraño') ;
      $select=Año::where('descripcion','LIKE',"%$añoseleccionado%")->get();
      foreach ($select as $selectaño) {
        $idselect="$selectaño->id";
        $descripcionselect="$selectaño->descripcion";
        $estadoselect="$selectaño->estado";
      }
      $idpersona=Auth::user()->id;
      $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $idcolegio="$idcol->id";
        }
      $todoestado= Año::where('id_colegio',$idcolegio)->get();
      foreach ($todoestado as $todoest) {
          $idaño="$todoest->id";
        }
      $grado=Grado::where('id_anio',$idaño)->get();
      if($grado->isEmpty()){
      $request->validate([
            'grado' => 'required',
            'docente' => 'required',
            'año' => 'required',
        ]);
    }
      else{
        foreach ($grado as $descri) {
          $descripciongrado="$descri->descripcion";
          $idaños="$descri->id_anio";
        }
      $todoestados= Año::where('id',$idaños)->get();
      foreach ($todoestados as $esta) {
          $añoid="$esta->descripcion";
        }
      $request->validate([
            'grado' => 'required|unique:grado,descripcion,'.$descripciongrado,
            'docente' => 'required',
            'año' => 'required|unique:grado,id_anio,'.$añoid,
        ]);
    }

      /*Busca el id del docente que fue seleccionado al momento de la creación*/
      $iddocente=Docente::all()->where('nombredocente',$request->docente);
      foreach ($iddocente as $iddoc) {
        $iddoc= "$iddoc->id";
      }
      $seleccion=$request->grado;
      $todosalumnos=Alumno::all();
      $alumnos=Alumno::where('grado',$seleccion)->pluck("id");

      /*Crea un nuevo grado y asigna el valor a cada uno de sus atributos*/
      $grado=new Grado();
      $grado->descripcion=$request->grado;
      if(strpos($grado->descripcion, 'Primer grado') !== False){
        $grado->num_grado= '1';
      }
      if(strpos($grado->descripcion, 'Segundo grado') !== False){
        $grado->num_grado= '2';
      }
      if(strpos($grado->descripcion, 'Tercer grado') !== False){
        $grado->num_grado= '3';
      }
      if(strpos($grado->descripcion, 'Cuarto grado') !== False){
        $grado->num_grado= '4';
      }
      if(strpos($grado->descripcion, 'Quinto grado') !== False){
        $grado->num_grado= '5';
      }
      if(strpos($grado->descripcion, 'Sexto grado') !== False){
        $grado->num_grado= '6';
      }
      if(strpos($grado->descripcion, 'Séptimo grado') !== False){
        $grado->num_grado= '7';
      }
      $grado->id_alumnos=$alumnos;
      $grado->id_docentes= $iddoc;
      $idaño=Año::all()->where('descripcion',$request->año);
      foreach ($idaño as $idaños) {
        $añoid="$idaños->id";
      }
      $grado->id_anio=$añoid;
      $grado->save();

    $estado= Año::where('estado','activo')->where('id_colegio',$idcolegio)->get();
    foreach ($estado as $idaño) {
      $idest="$idaño->id";
      $descripcionaño="$idaño->descripcion";
    }
    $idpersona=Auth::user()->id;
      $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $idcolegio="$idcol->id";
        }
    $todoestado= Año::where('id_colegio',$idcolegio)->get();
    foreach ($todoestado as $todoest) {
      $todoesta="$todoest->id";
    }
    $docentesespe= Docente::all()->sortBy('nombredocente')->where('especialidad','!=','Grado');
      $grado = Grado::where('id_anio',$idest)->orderBy('num_grado','ASC')->get();
      if(empty($idest)){
        $descripcionaño=" ";
        $descripcionselect=" ";
        $estadoselect=" "; 
        $grado = Grado::where('id_anio',$todoesta)->orderBy('num_grado','ASC')->get();
        return view('añoescolar.listadogrado',compact('todoestado','docentesespe','colegio','estado','descripcionaño','descripcionselect','estadoselect','grado'));
      }
      else{
      $grado = Grado::where('id_anio',$idest)->orderBy('num_grado','ASC')->get();
      $grados = Grado::where('id_anio',$idest)->orderBy('num_grado','ASC')->pluck("id_alumnos");                         
                                
      return view('añoescolar.listadogrado',compact('grado','todoestado','docentesespe','descripcionselect','colegio','estadoselect','descripcionaño','estado','todosalumnos'));
    }

    }
    public function destroy(Año $id)
    {
        $id->delete();
        return back()->with('success','El año escolar se eliminó correctamente.');
    }
    public function editaraño(Año $id)
    {
      $idpersona=Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $periodocolegio="$idcol->periodo";
          $idcolegio="$idcol->id";
        }
      $division=Colegio::where('id',$idcolegio)->get();
        foreach ($division as $div) {
            $divcol="$div->divisiones";
        }
        $res = preg_replace('/[\[\]\.\;\" "]+/', '', $divcol);
        $divcol=explode(',', $res);
        $contador=count($divcol)-1;
        for ($i=0; $i <= $contador ; $i++) { 
        $nombredivision[]=Abecedario::where('id',$divcol[$i])->pluck("letras");
        }
      return view('añoescolar.editar', compact('id','periodocolegio'));
    }
    public function actualizaraño(Request $request,$id)
    {
        $año = Año::findOrFail($id);
        $idpersona=Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $idcolegio="$idcol->id";
          $periodocolegio="$idcol->periodo";
        }

         if($periodocolegio=='Bimestre'){
         $request->validate([
            'descripcion' => ['required', 'int','unique:año,descripcion,'. $id],
            'fechainicio' => ['required','date("Y",fechainicio):descripcion'],
            'fechafin' => ['required','after_or_equal:fechainicio'],
            'inicioperiodo1' =>['required','date_equals:fechainicio'],
            'finperiodo1' =>'required',
            'inicioperiodo2' =>['required','after_or_equal:finperiodo1'],
            'finperiodo2' =>'required',
            'inicioperiodo3' =>['required','after_or_equal:finperiodo2'],
            'finperiodo3' =>'required',
            'inicioperiodo4' =>['required','after_or_equal:finperiodo3'],
            'finperiodo4' =>['required','date_equals:fechafin'],
        ]);}
         if($periodocolegio=='Trimestre'){
         $request->validate([
            'descripcion' => ['required', 'int','unique:año,descripcion,'. $id],
            'fechainicio' => 'required',
            'fechafin' => ['required','after_or_equal:fechainicio'],
            'inicioperiodo1' =>['required','date_equals:fechainicio'],
            'finperiodo1' =>'required',
            'inicioperiodo2' =>['required','after_or_equal:finperiodo1'],
            'finperiodo2' =>'required',
            'inicioperiodo3' =>['required','after_or_equal:finperiodo2'],
            'finperiodo3' =>['required','date_equals:fechafin'],
        ]);}
         if($periodocolegio=='Cuatrimestre'){
         $request->validate([
            'descripcion' => ['required', 'int','unique:año,descripcion,'. $id],
            'fechainicio' => 'required',
            'fechafin' => ['required','after_or_equal:fechainicio'],
            'inicioperiodo1' =>['required','date_equals:fechainicio'],
            'finperiodo1' =>'required',
            'inicioperiodo2' =>['required','after_or_equal:finperiodo1'],
            'finperiodo2' =>['required','date_equals:fechafin'],
        ]);}
         if($periodocolegio=='Semestre'){
         $request->validate([
            'descripcion' => ['required', 'int','unique:año,descripcion,'. $id],
            'fechainicio' => ['required'],
            'fechafin' => ['required','after_or_equal:fechainicio'],
            'inicioperiodo1' =>['required','date_equals:fechainicio'],
            'finperiodo1' =>'required',
            'inicioperiodo2' =>['required','after_or_equal:finperiodo1'],
            'finperiodo2' =>['required','date_equals:fechafin'],
        ]);}
        $data= $request->only('descripcion','fechainicio','fechafin','inicioperiodo1','finperiodo1','inicioperiodo2','finperiodo2','inicioperiodo3','finperiodo3','inicioperiodo4','finperiodo4');
        $año->update($data);
        return redirect()->route('añoescolar')->with('success','El año escolar se modificó correctamente.');
    }
    public function actualizarestado(Request $request,$id)
    {
        $infoaño=Año::findOrFail($id);
        $idpersona=Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $idcolegio="$idcol->id";
        }        
        if($infoaño->estado=='inactivo'){
          if (Año::where('id_colegio',$idcolegio)->where('estado', '=', 'activo')->exists()){
          return redirect()->route('añoescolar')->with('danger','Ya existe un año escolar activo.');;
        }
        else{
        $esta = Año::findOrFail($id);
        $esta->estado= 'activo';
        $data= $request->only('esta');
        $esta->update($data);
        return redirect()->route('añoescolar')->with('success','El año escolar se modificó correctamente.');
        }
      }
        if($infoaño->estado=='activo'){
        $esta = Año::findOrFail($id);
        $esta->estado= 'cerrado';
        $data= $request->only('esta');
        $esta->update($data);
        return redirect()->route('añoescolar')->with('success','El año escolar se modificó correctamente.');
        }
        if($infoaño->estado=='cerrado'){
        $esta = Año::findOrFail($id);
        $esta->estado= 'inactivo';
        $data= $request->only('esta');
        $esta->update($data);
        return redirect()->route('añoescolar')->with('success','El año escolar se modificó correctamente.');
        }
 }
 public function editargrado($id)
    {
      $idpersona=Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $idcolegio="$idcol->id";
        }
        $maxgrado=Colegio::where('id',$idcolegio)->get();
        foreach ($maxgrado as $max) {
            $maximogrado="$max->grados";
        }
        $docentes= Docente::all()->sortBy('nombredocente')->where('especialidad','Grado')->where('colegio_id',$idcolegio);
      $año=Año::where('id_colegio',$idcolegio)->orderBy('descripcion','ASC')->get();
      $grados=Grado::findOrFail($id);
      return view('añoescolar.editargrado', compact('id','maximogrado','año','docentes','grados'));

    }
  public function actualizargrado(Request $request,$id)
    {
      $grados = Grado::findOrFail($id);
      $request->validate([
            'id_docentes' => 'required',
            'id_anio' => 'required',
        ]);
      $data= $request->only('id_anio','id_docentes');
      $grados->update($data);
        return redirect()->route('armadogrado')->with('success','El grado escolar se modificó correctamente.');
    }
    public function armadoespeciales(Request $request, $id)
    {
      $request->validate([
            'id_docentesespe' => ['required'],
        ]);
        $idpersona= Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach($colegio as $col)
            {   
                $idcolegio= "$col->id";
            };
        $todoestado= Año::where('id_colegio',$idcolegio)->get();
        $estado= Año::where('estado','activo')->where('id_colegio',$idcolegio)->get();
        foreach ($estado as $idaño) {
          $idest="$idaño->id";
        }
        $grado = Grado::where('id_anio',$idest)->orderBy('num_grado','ASC')->get();
        $docentesespe= Docente::all()->sortBy('nombredocente')->where('especialidad','!=','Grado');
        $checkBoxs = $request->id_docentesespe;
        $modificar = Grado::findOrFail($id);
        $data= $request->only('id_docentesespe');
        $modificar->update($data);
        return redirect()->route('armadogrado',compact('todoestado','grado','docentesespe'));
    }
}