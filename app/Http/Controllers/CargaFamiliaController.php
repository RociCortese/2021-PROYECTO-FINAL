<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Familia;
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

class CargaFamiliaController extends Controller
{
	public function editarfamilia(Familia $id)
    {
      return view('admin.alumnos.editarfam', compact('id'));
    }

    public function updatefamilia(Request $request, $id)
    {
        $fam = Familia::findOrFail($id);
        $request->validate([
            'dnifamilia' => ['required', 'int','digits_between:7,8','unique:familias,dnifamilia,'. $id],
            'nombrefamilia' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'apellidofamilia' => ['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'generofamilia' => ['required'],
            'telefono' => ['required','int'],
            'email' => ['required','string', 'email', 'max:255', 'unique:familias,email,'.$id],
            'vinculofamiliar' => ['required'],
        ]);
        $data= $request->only('dnifamilia','nombrefamilia','apellidofamilia','generofamilia','telefono','email','vinculofamiliar');
        $fam->update($data);
        return redirect()->route('alumnos.create')->with('success','La familia se modificó correctamente.');
    }
}
