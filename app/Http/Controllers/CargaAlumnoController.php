<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Familia;
use App\Models\User;
use App\Models\Año;
use App\Models\Grado;
use App\Models\Colegio;
use App\Models\Abecedario;
use Auth;
use Session;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemCreateRequest;
use App\Http\Requests\ItemUpdateRequest;
use Illuminate\Support\Facades\Validator;
use DB;
use Input;
use Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\InvoicePaid;
use App\Notifications\notifcreacion;

class CargaAlumnoController extends Controller
{
	public function index(Request $request)
    {
        if($request){
        $idusuario= Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idusuario);
        if($colegio->isEmpty())
        {
            return view('admin.alumnos.index',compact('colegio'));
        }
        else{
            foreach($colegio as $col)
            {   
                $idcolegio= "$col->id";
            }
        $apellido = trim($request->get('buscarapellido'));
        $nombre = trim($request->get('buscarnombre'));
        $dni = trim($request->get('buscardni'));
        $grado= trim($request->get('buscargrado'));
        $alumnos = Alumno::orderby('id','ASC')
           ->nombres($nombre)
           ->apellidos($apellido)
           ->dnis($dni)
           ->grados($grado)
           ->where('colegio_id',$idcolegio)
           ->paginate(5);
        return view('admin.alumnos.index', compact('apellido','nombre','dni','alumnos','colegio','grado')); 
                    }
                }
    }

    public function create(Request $request)
    {
        $idpersona=Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach ($colegio as $idcol) {
        $idcolegio="$idcol->id";
        }
        if($request){
        $apellidofam = trim($request->get('buscarapellidofamilia'));
        $familias= Familia::where('apellidofamilia','LIKE','%'.$apellidofam.'%')->where('colegio_id', $idcolegio)->paginate(5);
        $idusuario= Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idusuario);
        if($colegio->isEmpty())
        {
            return view('admin.alumnos.index',compact('colegio'));
        }
        else{
            foreach($colegio as $col)
            {   
                $idcolegio= "$col->id";
            }
        $maxgrado=Colegio::where('id',$idcolegio)->get();
        foreach ($maxgrado as $max) {
            $maximogrado="$max->grados";
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
        return view('admin.alumnos.create', compact('apellidofam','familias','maximogrado','nombredivision'))->with('success', 'El alumno se cargó correctamente.');
                    }
    }
}
    public function store(Request $request)
    {
         $request->validate([
            'dnialumno' => ['required', 'int','digits_between:7,8','unique:alumnos'],
            'nombrealumno' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellidoalumno' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'fechanacimiento' => 'required',
            'generoalumno' => ['required'],
            'domicilio' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'localidad' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'provincia' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'grado' => 'required',
            ]);
        $checkselect=$request->check;
        $alumno=new Alumno();
        $alumno->nombrealumno=$request->nombrealumno;
        $alumno->apellidoalumno=$request->apellidoalumno;
        $alumno->nombrecompleto=$request->nombrealumno.' '.$request->apellidoalumno;
        $alumno->dnialumno=$request->dnialumno;
        $alumno->generoalumno=$request->generoalumno;
        $alumno->fechanacimiento=$request->fechanacimiento;
        $alumno->domicilio=$request->domicilio;
        $alumno->localidad=$request->localidad;
        $alumno->provincia=$request->provincia;
        $alumno->grado=$request->grado;
        $alumno->familias_id=$checkselect;
        $idusuario= Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idusuario);
        foreach($colegio as $col)
            {   
                $idcolegio= "$col->id";
            };
        $alumno->colegio_id=$idcolegio;
        $alumno->save();
        $fechacreacion=Alumno::where('dnialumno',$alumno->dnialumno)->pluck("created_at");
        $fechacreacion = preg_replace('/[\[\]\.\;\" "]+/', '', $fechacreacion);
        $añoactual = substr($fechacreacion, 0, 4);
        $añolectivo=Año::where('descripcion',$añoactual)->where('id_colegio',$idcolegio)->get();
        foreach($añolectivo as $añolect){
        $estado="$añolect->estado";
        $idaño="$añolect->id";
        }
        $gradoexiste=Grado::where('descripcion',$alumno->grado)->where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        if($estado=='activo' and sizeof($gradoexiste)!=0){
        $idalumnos=Grado::where('descripcion',$alumno->grado)->where('id_anio',$idaño)->where('colegio_id',$idcolegio)->get();
        foreach($idalumnos as $idalu){
        $alumnos="$idalu->id_alumnos";
        }
        $alumnos = preg_replace('/[\[\]\.\;\" "]+/', '', $alumnos);
        $idalumnos='['.$alumnos . ',' .$alumno->id.']';
        $gradoamodificar=Grado::where('descripcion',$alumno->grado)->where('id_anio',$idaño)->where('colegio_id',$idcolegio)->first();
        $gradoamodificar->id_alumnos=$idalumnos;
        $gradoamodificar->save();
        return redirect()->route('alumnos.index')
                        ->with('success', 'El alumno se cargó correctamente y se agregó al grado correspondiente.');
        }

         return redirect()->route('alumnos.index')
                        ->with('success', 'El alumno se cargó correctamente.');
        }
    public function crearfamilia(Request $request){
        $idusuario= Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idusuario);
        foreach($colegio as $col)
            {   
                $idcolegio= "$col->id";
            };
        $maxgrado=Colegio::where('id',$idcolegio)->get();
        foreach ($maxgrado as $max) {
            $maximogrado="$max->grados";
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
        $apellidofam = trim($request->get('buscarapellidofamilia'));
        $familias= Familia::where('apellidofamilia','LIKE','%'.$apellidofam.'%')->where('colegio_id', $idcolegio)->paginate(5);
        $request->validate([
            'dnifamilia' => ['required', 'int','digits_between:7,8','unique:familias'],
            'nombrefamilia' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellidofamilia' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'generofamilia' => ['required'],
            'telefonofamilia' => ['required','int','min:1000000000','max:9999999999'],
            'email' => ['required','string', 'email', 'max:255', 'unique:familias'],
            'vinculofamiliar' => ['required'],
            ]);
        $familia=new Familia();
        $familia->nombrefamilia=$request->nombrefamilia;
        $familia->apellidofamilia=$request->apellidofamilia;
        $familia->dnifamilia=$request->dnifamilia;
        $familia->generofamilia=$request->generofamilia;
        $familia->telefono=$request->telefonofamilia;
        $familia->email=$request->email;
        $familia->vinculofamiliar=$request->vinculofamiliar;
        $familia->colegio_id=$idcolegio;
        $familia->save();
        $idfamilia=$familia->id;
        $emfam=$familia->email;
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $password = "";
        for($i=0;$i<8;$i++) {
        $password .= substr($str,rand(0,62),1);
        }
        $user=new User();
        $user->name =$request->nombrefamilia . ' ' . $request->apellidofamilia;
        $user->email=$emfam;
        $user->passwordenc=Crypt::encrypt($password);
        $user->password=Hash::make($password);
        $user->role='familia';
        $user->idpersona=$idfamilia;
        $user->colegio_id=$idcolegio;
        $user->save();
        $password=Crypt::decrypt($user->passwordenc);
        $user->notify(new notifcreacion($user->email,$password));
        return view('admin.alumnos.create',compact('nombredivision','maximogrado','apellidofam','familias')); 
}
    
    public function showalumnos($id)
    {
        $alu=Alumno::findOrFail($id);
        $familiaid=$alu->familias_id;
        $familia = Familia::findOrFail($familiaid);
        return view('admin.alumnos.showalumnos',compact('alu','familia')); 
    }

    public function showfamilia($id)
    {
        $fam = Familia::findOrFail($id);
        return view('admin.alumnos.showfamilias',compact('fam')); 
    }

     public function editaralumno($id)
    {
        $alu=Alumno::findOrFail($id);
        $familiaid=$alu->familias_id;
        $fam = Familia::findOrFail($familiaid);
        return view('admin.alumnos.editaralumno', compact('alu','fam'));
    }

    public function update(Request $request,$id)
    {
        $alu= Alumno::findOrFail($id);
        $request->validate([
            'dnialumno' => ['required', 'int','digits_between:7,8','unique:alumnos,dnialumno,'. $id],
            'nombrealumno' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellidoalumno' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'fechanacimiento' => 'required',
            'generoalumno' => ['required'],
            'domicilio' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'localidad' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'provincia' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
        ]);
        $data= $request->only('dnialumno','nombrealumno','apellidoalumno','fechanacimiento','generoalumno','domicilio','localidad','provincia');
        $alu->update($data);
        $familiaid=$alu->familias_id;
        $fam = Familia::findOrFail($familiaid);
        $request->validate([
            'dnifamilia' => ['required', 'int','digits_between:7,8','unique:familias,dnifamilia,'. $familiaid],
            'nombrefamilia' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellidofamilia' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'generofamilia' => ['required'],
            'telefono' => ['required','int','min:1000000000','max:9999999999'],
            'email' => ['required','string', 'email', 'max:255','unique:familias,email,'.$familiaid],
            'vinculofamiliar' => ['required'],
        ]);
        $data2= $request->only('dnifamilia','nombrefamilia','apellidofamilia','generofamilia','telefono','email','vinculofamiliar');
        $fam->update($data2);
        return redirect()->route('alumnos.index')->with('success','El alumno se modificó correctamente.');
    }
     public function destroy(Alumno $id)
    {
        $id->delete();
        return back()->with('success', 'El alumno se eliminó correctamente.');
    }   
}
