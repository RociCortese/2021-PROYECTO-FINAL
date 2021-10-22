<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\User;
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


class CargaDocenteController extends Controller
{
	public function index(Request $request)
    {

    	//$docentes = Docente::all();
        if($request){
        $apellido = trim($request->get('buscarapellido'));
        $docentes = Docente::where('apellido','LIKE','%'.$apellido.'%')->Paginate(5);
        return view('admin.docentes.index', compact('apellido','docentes')); 
                    }

    }
    

    public function create()
    {
        $docentes = Docente::all();
        return view('admin.docentes.create', compact('docentes'));
    }

    public function store(Request $request)
    {
         $request->validate([
            'dni' => ['required', 'int','digits_between:7,8','unique:docentes'],
            'nombre' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellido' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'fechanacimiento' => 'required',
            'genero' => ['required'],
            'domicilio' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'localidad' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'provincia' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'estadocivil' => ['required'],
            'telefono' => ['required','int'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:docentes'],
            'legajo' => ['required','int'],
            'especialidad' => ['required','regex:/^[\pL\s\-]+$/u','max:25'],
        ]);
        Docente::create($request->all());
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $password = "";
        for($i=0;$i<8;$i++) {
        $password .= substr($str,rand(0,62),1);
        }
        $user=new User();
        $user->email=$request->email;
        $user->passwordenc=Crypt::encrypt($password);
        $user->password=Hash::make($password);
        $user->role='docente';
        $user->idpersona='5';
        $user->save();
        $password=Crypt::decrypt($user->passwordenc);
        $user->notify(new notifcreacion($request->email,$password));
        return redirect()->route('docentes.index')->with('success', 'El docente se cargó correctamente.');
    } 

   public function show($id)
    {
      $doc=Docente::findOrFail($id);
      return view('admin.docentes.show', compact('doc'));
    }

    public function edit(Docente $id)
    {
      return view('admin.docentes.editar', compact('id'));
    }

    public function update(Request $request,$id)
    {
        $doc = Docente::findOrFail($id);
         $request->validate([
            'dni' => ['required', 'int','digits_between:7,8','unique:docentes,dni,'. $id],
            'nombre' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellido' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'fechanacimiento' => 'required',
            'genero' => ['required'],
            'domicilio' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'localidad' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'provincia' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'estadocivil' => ['required'],
            'telefono' => ['required','int'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:docentes,email,'. $id],
            'legajo' => ['required','int'],
            'especialidad' => ['required','regex:/^[\pL\s\-]+$/u','max:25'],
        ]);
        $data= $request->only('dni','nombre','apellido','fechanacimiento','genero','domicilio','localidad','provincia','estadocivil','telefono','email','legajo','especialidad');
        $doc->update($data);
        return redirect()->route('docentes.index')->with('success','El docente se modificó correctamente.');
    }


    public function destroy(Docente $id)
    {
        $id->delete();
        return back()->with('success','El docente se eliminó correctamente.');
    }

}
