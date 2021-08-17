<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('auth/login');
});
Auth::routes();
Auth::routes(['verify' => true]);
Route::get('verify', function () {
    return view('auth/verify');
});
Route::get('profile', function () {
// Solo podrán entrar los usuarios con tenga la verificación de correo
})->middleware('verified');



// Nos mostrará el formulario de login.
/*Route::get('login', 'App\Http\Controllers\AuthController@showLogin');*/

// Validamos los datos de inicio de sesión.
//Route::post('login', 'App\Http\Controllers\AuthController@postLogin');

// Nos indica que las rutas que están dentro de él sólo serán mostradas si antes el usuario se ha autenticado.
/*{
    // Esta será nuestra ruta de bienvenida.
    Route::get('/', function()
    {
        return View::make('home');
    });
    // Esta ruta nos servirá para cerrar sesión.
    Route::get('logout', 'App\Http\Controllers\AuthController@logOut');
});

/*Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');*/
