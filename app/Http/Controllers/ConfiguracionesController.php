<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Colegio;
use App\Models\User;
use App\Http\Requests;
use App\Http\Requests\ItemCreateRequest;
use App\Models\Abecedario;

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
        $divi=$request->input("divisiones");
        $divi=implode(' ',$divi);
        $request->validate([
            'periodo' => ['required'],
            'turno' => ['required'],
            'grados'=> ['required'],
            'divisiones' => ['required'],
            ]);
        $idpersona= Auth::user()->id;
        $colegio= Colegio::all()->where('users_id',$idpersona);
        foreach($colegio as $col)
            {   
                $idcolegio= "$col->id";
            };
        $modificar = Colegio::findOrFail($idcolegio);
        $data= $request->only('periodo','turno','grados','divisiones');
        $modificar->update($data);
        return redirect()->route('configuraciones')
                        ->with('success', 'Las configuraciones se guardaron correctamente.'); 
    }
    /**
    * Show the application dataAjax.
    *
    * @return \Illuminate\Http\Response
    */
    public function getAutocompletedivisiones(Request $request){
     $data = [];
    if($request->has('q')){
    $search = $request->q;
    $data =Abecedario::select("id","letras")
          ->where('letras','LIKE',"%$search%")
          ->get();
        }
    return response()->json($data);
   }
}
