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

/*Login*/
Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();
Route::get('/directivo', 'App\Http\Controllers\DirectivoController@index')->name('directivo')->middleware('directivo');
Route::get('/docente', 'App\Http\Controllers\DocenteController@index')->name('docente')->middleware('docente');
Route::get('/familia', 'App\Http\Controllers\FamiliaController@index')->name('familia')->middleware('familia');

/*Verificación de email*/
Auth::routes(['verify' => true]);
Route::get('verify', function () {
    return view('auth/verify');
});
Route::get('verificado', function () {
    return view('auth/verificado');
});
Route::get('profile', function () {
})->middleware('verified');

/*Carga de archivos*/

Route::get('formulario', 'App\Http\Controllers\StorageController@index')->name('formulario');
Route::post('storage/create', 'App\Http\Controllers\StorageController@store');

Route::get('storage/{archivo}', function ($archivo) {
     $public_path = public_path();
     $url = $public_path.'/storage/'.$archivo;
     //verificamos si el archivo existe y lo retornamos
     if (Storage::exists($archivo))
     {
       return response()->download($url);
     }
     //si no se encuentra lanzamos un error 404.
     abort(404);

});


Route::get('home', function () {
    //
})->name('home');

Route::get('profile/edit', function () {
    //
})->name('profile.edit');



