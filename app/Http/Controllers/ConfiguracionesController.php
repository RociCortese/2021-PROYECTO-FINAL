<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Colegio;
use App\Models\User;
use App\Http\Requests;
use App\Http\Requests\ItemCreateRequest;

class ConfiguracionesController extends Controller
{
  
    public function index()
    {
        $idpersona= Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach($colegio as $col)
            {   
                $idcolegio= "$col->id";
            };
        return view('Colegio.configuracionesbasicas', compact('colegio'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'periodo' => ['required'],
            'turno' => ['required'],
            'grados'=> ['required'],
            ]);
        $idpersona= Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach($colegio as $col)
            {   
                $idcolegio= "$col->id";
            };

        $modificar = Colegio::findOrFail($idcolegio);
        $data= $request->only('periodo','turno','grados');
        $modificar->update($data);
        return redirect()->route('configuraciones')
                        ->with('success', 'Las configuraciones se guardaron correctamente.'); 
    }
}
