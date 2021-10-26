<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Directivo;
use App\Models\Docente;
use Illuminate\Support\Facades\Crypt;

class ProfileController extends Controller
{
    public function index() 
    {
        $user = Auth::user();
        $idusuario=$user->idpersona;
        $contra = Crypt::decrypt($user->passwordenc);
        if($user->role=='directivo'){
        $directivo = Directivo::findOrFail($idusuario);
        return view('perfil', compact('user','directivo','contra'));
        }
        else if($user->role=='docente'){
        $docente = Docente::findOrFail($idusuario);
        return view('perfil', compact('user','docente','contra'));
        }
        else if($user->role=='familia'){
        $familia = Docente::findOrFail($idusuario);
        return view('perfil', compact('user','familia'));
        }
    }

    public function updatepersonal(Request $request)
    {
        $user = Auth::user();
        $idusuario=$user->idpersona;
        if($user->role=='directivo'){
        $request->validate([
            'nombre' => ['required', 'alpha', 'max:100'],
            'apellido' => ['required', 'alpha', 'max:100'],
            'dni' => ['required', 'int', 'digits_between:7,8','unique:directivos,dni,'. $idusuario],
            'telefono' => ['required', 'int'],
        ]);
        $emailmodificado=$request->only('email');
        auth()->user()->update($emailmodificado);
        $persona = Directivo::findOrFail($idusuario);
        $persona->email=$emailmodificado;
        $data= $request->only('nombre','apellido','dni','telefono','email');
        $persona->update($data);
        return back()->with('success', 'La información personal se ha actualizado correctamente.');
        }
        else if($user->role=='docente'){
            $request->validate([
            'nombredocente' => ['required', 'alpha', 'max:100'],
            'apellidodocente' => ['required', 'alpha', 'max:100'],
            'dnidocente' => ['required', 'int', 'digits_between:7,8','unique:docentes,dnidocente,'. $idusuario],
            'telefonodocente' => ['required', 'int'],
            'fechanacimientodoc' => 'required',
            'generodocente' => ['required'],
            'domiciliodocente' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'localidaddocente' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'provinciadocente' => ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/','max:50'],
            'estadocivildoc' => ['required'],
            'legajo' => ['required','int'],
            'especialidad' => ['required','regex:/^[\pL\s\-]+$/u','max:25'],
            ]);
        $emailmodificado=$request->only('email');
        auth()->user()->update($emailmodificado);
        $persona = Docente::findOrFail($idusuario);
        $persona->emaildocente=auth()->user()->email;
        $data= $request->only('dnidocente','nombredocente','apellidodocente','fechanacimientodoc','generodocente','domiciliodocente','localidaddocente','provinciadocente','estadocivildoc','telefonodocente','legajo','especialidad');
        $persona->update($data);
        return back()->with('success', 'La información personal se ha actualizado correctamente.');
        }

       
}
        
     public function updatecontra(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8','confirmed', 'regex:/[a-z]{1}/','regex:/[A-Z]{1}/']
        ]);
        
        auth()->user()->update(['passwordenc' => Crypt::encrypt($request->get('password'))]);
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);
        return back()->with('success', 'La contraseña se modificó correctamente.');
    }
}