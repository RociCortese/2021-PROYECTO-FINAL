<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Directivo;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Notifications\InvoicePaid;
use App\Notifications\emailverify;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/verify';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => ['required', 'alpha', 'max:100'],
            'apellido' => ['required', 'alpha', 'max:100'],
            'dni' => ['required', 'int', 'digits_between:7,8','unique:directivos'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:directivos'],
            'telefono' => ['required','int','min:1000000000','max:9999999999'],
            'password' => ['required', 'string', 'min:8','confirmed', 'regex:/[a-z]{1}/','regex:/[A-Z]{1}/']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $directivo=Directivo::create([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'dni' => $data['dni'],
            'email' => $data['email'],
            'telefono' => $data['telefono'], 
        ]); 
        $usuario=User::create([
            'name' => $data['nombre'] . ' ' . $data['apellido'],
            'role' =>'directivo',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'passwordenc' => Crypt::encrypt($data['password']),
            'idpersona' =>$directivo->id,
        ]);
        $usuario->notify(new emailverify($directivo->email));
    }
}
