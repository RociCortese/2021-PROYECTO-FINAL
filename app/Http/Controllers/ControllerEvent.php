<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\notifevento;
use App\Notifications\notifactualizarevento;
use App\Notifications\notifcancelevent;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class ControllerEvent extends Controller
{
    public function form(){
      return view("evento/form");
    }
    public function getAutocomplete(Request $request){
    $data = [];
    if($request->has('q')){
    $search = $request->q;
    $data =User::select("id","name")
          ->where('name','LIKE',"%$search%")
          ->where('name','!=',Auth::user()->name)
          ->get();
        }
    return response()->json($data);
   }
    public function create(Request $request){
      if($request->has('participantes')){
      $parti=$request->input("participantes");
      $parti=implode(' ',$parti);
    }
      $this->validate($request, [
      'titulo'     =>  ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ-]))+$/','max:20'],
      'tipo'     =>  'required',
      'descripcion' =>['max:150'],
      'lugar'  =>  ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ-]))+$/','max:20'],
      'fecha' =>  'required',
      'hora' => 'required',
      'participantes' =>  'required'
     ]);
      $evento=new Event();
      $evento->titulo=$request->input("titulo");
      $evento->tipo=$request->input("tipo");
      $evento->descripcion=$request->input("descripcion");
      $evento->lugar=$request->input("lugar");
      $evento->fecha=$request->input("fecha");
      $evento->hora=$request->input("hora");
      $evento->participantes=$parti;
      $evento->creador= Auth::user()->name;
       $titulo= $request->input("titulo");
        $tipo= $request->input("tipo");
        $descripcion= $request->input("descripcion");
        $lugar= $request->input("lugar");
        $fecha= $request->input("fecha");
        $hora= $request->input("hora");
        $creador= Auth::user()->name;
        $partipan=$parti;
      $evento->save();
      $array=explode(' ', $parti);
      $contador=count($array)-1;
      for ($i=0; $i <=$contador ; $i++) { 
        $emailusuario=User::where('id',$array[$i])->get();
      foreach ($emailusuario as $emailuser) {
        $emailuser->notify(new notifevento($creador,$tipo,$titulo,$descripcion,$lugar,$fecha,$hora));
}
      }
      
      return redirect()->route('calendario')->with('success', 'El evento se creo correctamente.');
    }

    public function details($id){

      $event = Event::find($id);

      return view("evento/calendario",[
        "event" => $event
      ]);

    }


    // =================== CALENDARIO =====================

    public function index(){

       $month = date("Y-m");
       //
       $data = $this->calendar_month($month);
       $mes = $data['month'];
       // obtener mes en espanol
       $mespanish = $this->spanish_month($mes);
       $mes = $data['month'];

       return view("evento/calendario",[
         'data' => $data,
         'mes' => $mes,
         'mespanish' => $mespanish
       ]);

   }

   public function index_month($month){

      $data = $this->calendar_month($month);
      $mes = $data['month'];
      // obtener mes en espanol
      $mespanish = $this->spanish_month($mes);
      $mes = $data['month'];

      return view("evento/calendario",[
        'data' => $data,
        'mes' => $mes,
        'mespanish' => $mespanish
      ]);
    }
    public function destroy(Event $id)
    {
       $eliminarevento = Event::find($id)->pluck("participantes");
       $fecha = Event::find($id)->pluck("fecha");
       $fecha= preg_replace('/[\[\]\.\;\""]+/', '', $fecha);
       $titulo = Event::find($id)->pluck("titulo");
       $titulo= preg_replace('/[\[\]\.\;\""]+/', '', $titulo);
       $res = preg_replace('/[\[\]\.\;\""]+/', '', $eliminarevento);
       $array=explode(' ', $res);
       $contador=count($array)-1;
       $id->delete();
       for ($i=0; $i <=$contador; $i++) { 
        $emailusuario=User::where('id',$array[$i])->get();
      foreach ($emailusuario as $emailuser) {
        $emailuser->notify(new notifcancelevent($titulo,$fecha));
}
      }      
       
       return back()->with('success','El evento se eliminó correctamente.');
    }
    public function editarevento(Event $id)
    {
      return view('evento.editar', compact('id'));
    }
    public function actualizarevento(Request $request,$id)
    {
      if($request->has('participantes')){
      $parti=$request->input("participantes");
      $parti=implode(' ',$parti);
    }
        $evento = Event::findOrFail($id);
        $this->validate($request, [
      'titulo'     =>  ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ-]))+$/','max:20'],
      'tipo'     =>  'required',
      'descripcion' =>['max:150'],
      'lugar'  =>  ['required','regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ-]))+$/','max:20'],
      'fecha' =>  'required',
      'hora' => 'required',
      'participantes' =>  'required'
     ]);
      $evento->titulo = $request->titulo;
      $evento->tipo = $request->tipo;
      $evento->descripcion = $request->descripcion;
      $evento->lugar = $request->lugar;
      $evento->fecha = $request->fecha;
      $evento->hora = $request->hora;
      $evento->participantes = $parti;
      $evento->creador= Auth::user()->name;
      $evento->save();
      $titulo= $request->input("titulo");
        $tipo= $request->input("tipo");
        $descripcion= $request->input("descripcion");
        $lugar= $request->input("lugar");
        $fecha= $request->input("fecha");
        $hora= $request->input("hora");
        $creador= Auth::user()->name;
      $array=explode(' ', $parti);
      $contador=count($array)-1;
      for ($i=0; $i <=$contador ; $i++) { 
        $emailusuario=User::where('id',$array[$i])->get();
      foreach ($emailusuario as $emailuser) {
        $emailuser->notify(new notifactualizarevento($creador,$tipo,$titulo,$descripcion,$lugar,$fecha,$hora));
}
      }
        return redirect()->route('calendario')->with('success','El evento se modificó correctamente.');
    }

    public static function calendar_month($month){
      //$mes = date("Y-m");
      $mes = $month;
      //sacar el ultimo de dia del mes
      $daylast =  date("Y-m-d", strtotime("last day of ".$mes));
      //sacar el dia de dia del mes
      $fecha      =  date("Y-m-d", strtotime("first day of ".$mes));
      $daysmonth  =  date("d", strtotime($fecha));
      $montmonth  =  date("m", strtotime($fecha));
      $yearmonth  =  date("Y", strtotime($fecha));
      // sacar el lunes de la primera semana
      $nuevaFecha = mktime(0,0,0,$montmonth,$daysmonth,$yearmonth);
      $diaDeLaSemana = date("w", $nuevaFecha);
      $nuevaFecha = $nuevaFecha - ($diaDeLaSemana*24*3600); //Restar los segundos totales de los dias transcurridos de la semana
      $dateini = date ("Y-m-d",$nuevaFecha);
      //$dateini = date("Y-m-d",strtotime($dateini."+ 1 day"));
      // numero de primer semana del mes
      $semana1 = date("W",strtotime($fecha));
      // numero de ultima semana del mes
      $semana2 = date("W",strtotime($daylast));
      // semana todal del mes
      // en caso si es diciembre
      if (date("m", strtotime($mes))==12) {
          $semana = 5;
      }
      else if (date("m", strtotime($mes))==1) {
          $semana = 6;
      }
      else {
        $semana = ($semana2-$semana1)+1;
      }
      // semana todal del mes
      $datafecha = $dateini;
      $calendario = array();
      $iweek = 0;
      while ($iweek < $semana):
          $iweek++;
          //echo "Semana $iweek <br>";
          //
          $weekdata = [];
          for ($iday=0; $iday < 7 ; $iday++){
            // code...
            $datafecha = date("Y-m-d",strtotime($datafecha."+ 1 day"));
            $datanew['mes'] = date("M", strtotime($datafecha));
            $datanew['dia'] = date("d", strtotime($datafecha));
            $datanew['fecha'] = $datafecha;

            //AGREGAR CONSULTAS EVENTO
            $datanew['evento'] = Event::where("fecha",$datafecha)->get();
            array_push($weekdata,$datanew);
          }
          $dataweek['semana'] = $iweek;
          $dataweek['datos'] = $weekdata;
          array_push($calendario,$dataweek);
      endwhile;
      $nextmonth = date("Y-M",strtotime($mes."+ 1 month"));
      $lastmonth = date("Y-M",strtotime($mes."- 1 month"));
      $month = date("M",strtotime($mes));
      $yearmonth = date("Y",strtotime($mes));
      //$month = date("M",strtotime("2019-03"));
      $data = array(
        'next' => $nextmonth,
        'month'=> $month,
        'year' => $yearmonth,
        'last' => $lastmonth,
        'calendar' => $calendario,
      );
      return $data;
    }

    public static function spanish_month($month)
    {

        $mes = $month;
        if ($month=="Jan") {
          $mes = "Enero";
        }
        elseif ($month=="Feb")  {
          $mes = "Febrero";
        }
        elseif ($month=="Mar")  {
          $mes = "Marzo";
        }
        elseif ($month=="Apr") {
          $mes = "Abril";
        }
        elseif ($month=="May") {
          $mes = "Mayo";
        }
        elseif ($month=="Jun") {
          $mes = "Junio";
        }
        elseif ($month=="Jul") {
          $mes = "Julio";
        }
        elseif ($month=="Aug") {
          $mes = "Agosto";
        }
        elseif ($month=="Sep") {
          $mes = "Septiembre";
        }
        elseif ($month=="Oct") {
          $mes = "Octubre";
        }
        elseif ($month=="Oct") {
          $mes = "December";
        }
        elseif ($month=="Dec") {
          $mes = "Diciembre";
        }
        else {
          $mes = $month;
        }
        return $mes;
    }

    public function listadofamilias(){
    $idautenticado=Auth::user()->id;
    $eventosproximos=Event::where('participantes', $idautenticado)->where('fecha', '>=', Carbon::now()->format('Y-m-d'))->orderBy('fecha','ASC')->take(6)->get();
    $eventosanteriores=Event::where('participantes', $idautenticado)->where('fecha', '<', Carbon::now()->format('Y-m-d'))->orderBy('fecha','DESC')->paginate(5);
    return view('evento.eventosfamilia',compact('eventosproximos','eventosanteriores'));
    }

}