<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Año;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\Colegio;

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
        }
    $años = Año::orderBy('estado','ASC')->where('id_colegio',$idcolegio)->paginate(5);
    return view('añoescolar.listado',compact('años'));
   }
    public function create(Request $request)
    {
        return view('añoescolar.create');
    }
    public function store(Request $request)
    {
         $request->validate([
            'descripcion' => ['required', 'int','unique:año'],
            'fechainicio' => 'required',
            'fechafin' => 'required',
        ]);
        $idpersona=Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
          $idcolegio="$idcol->id";
        }
        $año=new Año();
        $año->descripcion=$request->descripcion;
        $descri=$año->descripcion;
        $año->fechainicio=$request->fechainicio;
        $año->fechafin=$request->fechafin;
        $año->estado='inactivo';
        $año->id_colegio=$idcolegio;
        $año->save();   
        return view('añoescolar.create', compact('descri'));
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
      $grado = Grado::where('id_año',$idest)->orderBy('descripcion','ASC')->get();

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

      /*Busca todos los años que pertenecen al id del colegio que se encuentra logueado*/
      $año=Año::all()->where('id_colegio',$idcolegio);

      return view('añoescolar.creategrado',compact('docentes','año'));
    }

    public function armadogrado(Request $request)
    {
      $request->validate([
            'grado' => ['required'],
            'docente' => 'required',
            'año' => 'required',
        ]);

      /*Busca el id del docente que fue seleccionado al momento de la creación*/
      $iddocente=Docente::all()->where('nombredocente',$request->docente);
      foreach ($iddocente as $iddoc) {
        $iddoc= "$iddoc->id";
      }

      /*Crea un nuevo grado y asigna el valor a cada uno de sus atributos*/
      $grado=new Grado();
      $grado->descripcion=$request->grado;
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
    return view('añoescolar.listadogrado',compact('grado','todoestado')); 
    }
    public function destroy(Año $id)
    {
        $id->delete();
        return back()->with('success','El año escolar se eliminó correctamente.');
    }
    public function editaraño(Año $id)
    {
      return view('añoescolar.editar', compact('id'));
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
}