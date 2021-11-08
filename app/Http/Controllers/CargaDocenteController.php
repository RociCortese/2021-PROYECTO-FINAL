<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
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


class CargaDocenteController extends Controller
{
	public function index(Request $request)
    {
        if($request){
        $idusuario= Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idusuario);
        $apellido = trim($request->get('buscarapellido'));
        $nombre = trim($request->get('buscarnombre'));
        $dni = trim($request->get('buscardni'));
        $docentes = Docente::orderby('id','DESC')
           ->nombres($nombre)
           ->apellidos($apellido)
           ->dnis($dni)
           ->paginate(5);
        return view('admin.docentes.index', compact('apellido','nombre','dni','docentes','colegio')); 
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
            'dnidocente' => ['required', 'int','digits_between:7,8','unique:docentes'],
            'nombredocente' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellidodocente' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'fechanacimientodoc' => 'required',
            'generodocente' => ['required'],
            'domiciliodocente' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'localidaddocente' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'provinciadocente' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'estadocivildoc' => ['required'],
            'telefonodocente' => ['required','int'],
            'emaildocente' => ['required', 'string', 'email', 'max:255', 'unique:docentes'],
            'legajo' => ['required','int'],
            'especialidad' => ['required','regex:/^[\pL\s\-]+$/u','max:25'],
        ]);
        $docentes= Docente::create($request->all());
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $password = "";
        for($i=0;$i<8;$i++) {
        $password .= substr($str,rand(0,62),1);
        }
        $user=new User();
        $user->email=$request->emaildocente;
        $user->passwordenc=Crypt::encrypt($password);
        $user->password=Hash::make($password);
        $user->role='docente';
        $user->idpersona=$docentes->id;
        $user->save();
        $password=Crypt::decrypt($user->passwordenc);
        $user->notify(new notifcreacion($request->emaildocente,$password));
        return redirect()->route('docentes.index')->with('success', 'El docente se cargó correctamente.');
    } 

   public function show($id)
    {
      $doc=Docente::findOrFail($id);
      return view('admin.docentes.show', compact('doc'));
    }

    public function editardoc(Docente $id)
    {
      return view('admin.docentes.editar', compact('id'));
    }

    public function update(Request $request,$id)
    {
        $doc = Docente::findOrFail($id);
         $request->validate([
            'dnidocente' => ['required', 'int','digits_between:7,8','unique:docentes,dni,'. $id],
            'nombredocente' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellidodocente' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'fechanacimientodoc' => 'required',
            'generodocente' => ['required'],
            'domiciliodocente' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'localidaddocente' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'provinciadocente' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'estadocivildoc' => ['required'],
            'telefonodocente' => ['required','int'],
            'emaildocente' => ['required', 'string', 'email', 'max:255', 'unique:docentes,email,'. $id],
            'legajo' => ['required','int'],
            'especialidad' => ['required','regex:/^[\pL\s\-]+$/u','max:25'],
        ]);
        $data= $request->only('dnidocente','nombredocente','apellidodocente','fechanacimientodoc','generodocente','domiciliodocente','localidaddocente','provinciadocente','estadocivildoc','telefonodocente','emaildocente','legajo','especialidad');
        $doc->update($data);
        return redirect()->route('docentes.index')->with('success','El docente se modificó correctamente.');
    }


    public function destroy(Docente $id)
    {
        $id->delete();
        return back()->with('success','El docente se eliminó correctamente.');
    }

}
