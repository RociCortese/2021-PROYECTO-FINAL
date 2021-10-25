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
        $email=$request->only('email');
        auth()->user()->update($email);
        $request->validate([
            'nombre' => ['required', 'alpha', 'max:100'],
            'apellido' => ['required', 'alpha', 'max:100'],
            'dni' => ['required', 'int', 'digits_between:7,8','unique:directivos,dni,'.$idusuario],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:directivos,email,'.$idusuario],
            'telefono' => ['required', 'int'],
        ]);
        if($user->role=='directivo'){
        $persona = Directivo::findOrFail($idusuario);
        $data= $request->only('nombre','apellido','dni','telefono','email');
        }
        if($user->role=='docente'){
        $persona = Docente::findOrFail($idusuario);
        $data= $request->only('dni','nombre','apellido','fechanacimiento','genero','domicilio','localidad','provincia','estado civil','telefono','email','legajo','especialidad');
        }
        else if($user->role=='familia'){
        $persona = Docente::findOrFail($idusuario);
        }
        $persona->update($data);
        return back()->with('success', 'La información personal se ha actualizado correctamente.');
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