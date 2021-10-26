<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Familia;
use App\Models\User;
use App\Models\Colegio;
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
        $apellido = trim($request->get('buscarapellido'));
        $nombre = trim($request->get('buscarnombre'));
        $dni = trim($request->get('buscardni'));
        $alumnos = Alumno::orderby('id','DESC')
           ->nombres($nombre)
           ->apellidos($apellido)
           ->dnis($dni)
           ->paginate(5);
        return view('admin.alumnos.index', compact('apellido','nombre','dni','alumnos','colegio')); 
                    }
    }

    public function create(Request $request)
    {
        if($request){
        $apellidofam = trim($request->get('buscarapellidofamilia'));
        $familias= Familia::where('apellidofamilia','LIKE','%'.$apellidofam.'%')->paginate(5);
        return view('admin.alumnos.create', compact('apellidofam','familias'))->with('success', 'El alumno se cargó correctamente.');
                    }
    }

    public function store(Request $request)
    {
        $check=$request->check;
         $request->validate([
            'dnialumno' => ['required', 'int','digits_between:7,8','unique:alumnos'],
            'nombrealumno' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellidoalumno' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'fechanacimiento' => 'required',
            'generoalumno' => ['required'],
            'domicilio' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'localidad' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'provincia' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            ]);
            if(empty($check)){
        $request->validate([
            'dnifamilia' => ['required', 'int','digits_between:7,8','unique:familias'],
            'nombrefamilia' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellidofamilia' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'generofamilia' => ['required'],
            'telefono' => ['required','int'],
            'email' => ['required','string', 'email', 'max:255', 'unique:familias'],
            'vinculofamiliar' => ['required'],
            ]);
            } 
        if(empty($check)){
        $familia=new Familia();
        $familia->nombrefamilia=$request->nombrefamilia;
        $familia->apellidofamilia=$request->apellidofamilia;
        $familia->dnifamilia=$request->dnifamilia;
        $familia->generofamilia=$request->generofamilia;
        $familia->telefono=$request->telefono;
        $familia->email=$request->email;
        $familia->vinculofamiliar=$request->vinculofamiliar;
        $familia->save();
        $idfamilia=$familia->id;
        $emfam=$familia->email;
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $password = "";
        for($i=0;$i<8;$i++) {
        $password .= substr($str,rand(0,62),1);
        }
        $user=new User();
        $user->email=$emfam;
        $user->passwordenc=Crypt::encrypt($password);
        $user->password=Hash::make($password);
        $user->role='familia';
        $user->idpersona=$idfamilia;
        $user->save();
        $password=Crypt::decrypt($user->passwordenc);
        $user->notify(new notifcreacion($user->email,$password));
        }
        else{
            $idfamilia=$check;
        }
        $alumno=new Alumno();
        $alumno->nombrealumno=$request->nombrealumno;
        $alumno->apellidoalumno=$request->apellidoalumno;
        $alumno->dnialumno=$request->dnialumno;
        $alumno->generoalumno=$request->generoalumno;
        $alumno->fechanacimiento=$request->fechanacimiento;
        $alumno->domicilio=$request->domicilio;
        $alumno->localidad=$request->localidad;
        $alumno->provincia=$request->provincia;
        $alumno->familias_id=$idfamilia;
        $alumno->save();
        
        
        
        return redirect()->route('alumnos.index')
                        ->with('success', 'El alumno se cargó correctamente.');
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
            'telefono' => ['required','int'],
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
