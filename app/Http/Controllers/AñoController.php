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
    $años = Año::orderBy('estado','ASC')->where('id_colegio',$idcolegio)->paginate(5);
    return view('añoescolar.listado',compact('años','periodocolegio'));
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
            'fechainicio' => 'required',
            'fechafin' => 'required',
            'inicioperiodo1' =>'required',
            'finperiodo1' =>'required',
            'inicioperiodo2' =>'required',
            'finperiodo2' =>'required',
            'inicioperiodo3' =>'required',
            'finperiodo3' =>'required',
            'inicioperiodo4' =>'required',
            'finperiodo4' =>'required',
        ]);}
         if($periodocolegio=='Trimestre'){
         $request->validate([
            'descripcion' => ['required', 'int','unique:año'],
            'fechainicio' => 'required',
            'fechafin' => 'required',
            'inicioperiodo1' =>'required',
            'finperiodo1' =>'required',
            'inicioperiodo2' =>'required',
            'finperiodo2' =>'required',
            'inicioperiodo3' =>'required',
            'finperiodo3' =>'required',
        ]);}
         if($periodocolegio=='Cuatrimestre'){
         $request->validate([
            'descripcion' => ['required', 'int','unique:año'],
            'fechainicio' => 'required',
            'fechafin' => 'required',
            'inicioperiodo1' =>'required',
            'finperiodo1' =>'required',
            'inicioperiodo2' =>'required',
            'finperiodo2' =>'required',
        ]);}
         if($periodocolegio=='Semestre'){
         $request->validate([
            'descripcion' => ['required', 'int','unique:año'],
            'fechainicio' => 'required',
            'fechafin' => 'required',
            'inicioperiodo1' =>'required',
            'finperiodo1' =>'required',
            'inicioperiodo2' =>'required',
            'finperiodo2' =>'required',
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
        $año->inicioperiodo5=$request->inicioperiodo5;
        $año->finperiodo5=$request->finperiodo5;
        $año->inicioperiodo6=$request->inicioperiodo6;
        $año->finperiodo6=$request->finperiodo6;
        $año->id_colegio=$idcolegio;
        $año->save();   
         $años = Año::orderBy('estado','ASC')->where('id_colegio',$idcolegio)->paginate(5);
        return view('añoescolar.listado', compact('descri','periodocolegio','años'));
    } 

    public function listadogrado(Request $request)
    {
      /*Busca el id del colegio que se encuentra logueado (según el directivo)*/
      $idpersona=Auth::user()->id;
      $colegio= Colegio::all()->where('users_id',$idpersona);
      foreach ($colegio as $idcol) {
        $idcolegio="$idcol->id";
      }

      /*Busca el id de los años que están activos y pertenecen al colegio que se encuentra logueado*/
      $estado= Año::where('estado','activo')->where('id_colegio',$idcolegio)->get();
      foreach ($estado as $idaño) {
        $idest="$idaño->id";
      }

      /*Busca todos los años que pertenecen al colegio que se encuentra logueado*/
      $todoestado= Año::where('id_colegio',$idcolegio)->get();

      /*Busca todos los grados que están relacionados con el año activo y los ordena*/
      $grado = Grado::where('id_año',$idest)->orderBy('num_grado','ASC')->get();

      $docentesespe= Docente::all()->sortBy('nombredocente')->where('especialidad','!=','Grado');
      return view('añoescolar.listadogrado',compact('grado','todoestado','docentesespe'));
    }

    public function creategrado(Request $request)
    {
      /*Busca todos los docentes cuya especialidad es grado*/
      $docentes= Docente::all()->sortBy('nombredocente')->where('especialidad','Grado');

      /*Busca el id del colegio que se encuentra logueado*/
      $idpersona=Auth::user()->id;
      $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $idcolegio="$idcol->id";
        }
        $maxgrado=Colegio::where('id',$idcolegio)->get();
        foreach ($maxgrado as $max) {
            $maximogrado="$max->grados";
        }

      /*Busca todos los años que pertenecen al id del colegio que se encuentra logueado*/
      $año=Año::all()->where('id_colegio',$idcolegio);

      return view('añoescolar.creategrado',compact('docentes','año','maximogrado'));
    }

    public function armadogrado(Request $request)
    {
      $idpersona=Auth::user()->id;
      $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $idcolegio="$idcol->id";
        }
      $todoestado= Año::where('id_colegio',$idcolegio)->get();
      foreach ($todoestado as $todoest) {
          $idaño="$todoest->id";
        }
      $grado=Grado::where('id_año',$idaño)->get();
      foreach ($grado as $descri) {
          $descripciongrado="$descri->descripcion";
          $idaños="$descri->id_año";
        }
      $todoestados= Año::where('id',$idaños)->get();
      foreach ($todoestados as $esta) {
          $añoid="$esta->descripcion";
        }
      $request->validate([
            'grado' => 'required|unique:grado,descripcion,'.$descripciongrado,
            'docente' => 'required',
            'año' => 'required|unique:grado,id_año,'.$añoid,
        ]);

      /*Busca el id del docente que fue seleccionado al momento de la creación*/
      $iddocente=Docente::all()->where('nombredocente',$request->docente);
      foreach ($iddocente as $iddoc) {
        $iddoc= "$iddoc->id";
      }
      $seleccion=$request->grado;
      $todosalumnos=Alumno::all();
      $alumnos=Alumno::where('grado',$seleccion)->get();

      /*Crea un nuevo grado y asigna el valor a cada uno de sus atributos*/
      $grado=new Grado();
      $grado->descripcion=$request->grado;
      if($request->grado=='Primer grado'){
        $grado->num_grado= '1';
      }
      if($request->grado=='Segundo grado'){
        $grado->num_grado= '2';
      }
      if($request->grado=='Tercer grado'){
        $grado->num_grado= '3';
      }
      if($request->grado=='Cuarto grado'){
        $grado->num_grado= '4';
      }
      if($request->grado=='Quinto grado'){
        $grado->num_grado= '5';
      }
      if($request->grado=='Sexto grado'){
        $grado->num_grado= '6';
      }
      if($request->grado=='Séptimo grado'){
        $grado->num_grado= '7';
      }
      $grado->id_docentes= $iddoc;
      $idaño=Año::all()->where('descripcion',$request->año);
      foreach ($idaño as $idaños) {
        $añoid="$idaños->id";
      }
      $grado->id_año=$añoid;
      $grado->save();

      /*Busca el id del colegio que se encuentra logueado*/
      $idpersona=Auth::user()->id;
      $colegio= Colegio::all()->where('users_id',$idpersona);
      foreach ($colegio as $idcol) {
        $idcolegio="$idcol->id";
      }

    $estado= Año::where('estado','activo')->where('id_colegio',$idcolegio)->get();
    foreach ($estado as $idaño) {
      $idest="$idaño->id";
    }
    $idpersona=Auth::user()->id;
      $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $idcolegio="$idcol->id";
        }
    $todoestado= Año::where('id_colegio',$idcolegio)->get();
    $grado = Grado::where('id_año',$idest)->orderBy('descripcion','ASC')->get();
    $docentesespe= Docente::all()->sortBy('nombredocente')->where('especialidad','!=','Grado');
    return view('añoescolar.listadogrado',compact('grado','todoestado','alumnos','docentesespe','todosalumnos'));

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
        }
      return view('añoescolar.editar', compact('id','periodocolegio'));
    }
    public function actualizaraño(Request $request,$id)
    {
        $año = Año::findOrFail($id);
         $request->validate([
            'descripcion' => ['required', 'int'],
            'fechainicio' => 'required',
            'fechafin' => 'required',
        ]);

        $data= $request->only('descripcion','fechainicio','fechafin');
        $año->update($data);
        return redirect()->route('añoescolar')->with('success','El año escolar se modificó correctamente.');
    }
    public function actualizargrado(Request $request,$id)
    {
        $grado = Grado::findOrFail($id);
         $request->validate([
            'grado' => 'required|unique:grado,descripcion',
            'docente' => 'required',
            'año' => 'required|unique:grado,id_año',
        ]);
        $data= $request->only('grado','docente','año');
        $año->update($data);
        return view('añoescolar.listadogrado');
    }
    public function actualizarestado(Request $request,$id)
    {
        $infoaño=Año::findOrFail($id);
        if($infoaño->estado=='inactivo'){
        $esta = Año::findOrFail($id);
        $esta->estado= 'activo';
        $data= $request->only('esta');
        $esta->update($data);
        return redirect()->route('añoescolar')->with('success','El año escolar se modificó correctamente.');
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
        $grado = Grado::where('id_año',$idest)->orderBy('descripcion','ASC')->get();
        $docentesespe= Docente::all()->sortBy('nombredocente')->where('especialidad','!=','Grado');
        $checkBoxs = $request->id_docentesespe;
        foreach ($checkBoxs as $check) {
        $modificar = Grado::findOrFail($id);
        $data= $request->only('id_docentesespe');
        $modificar->update($data);
        }

        return view('añoescolar.listadogrado',compact('todoestado','grado','docentesespe'));
    }
}