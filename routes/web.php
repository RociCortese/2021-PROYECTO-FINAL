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
Route::get('profile', function () {
})->middleware('verified');
Route::get('verificado', function () {
    return view('auth/verificado');
});


/*Carga de archivos*/

Route::get('formulario', 'App\Http\Controllers\StorageController@index')->name('formulario');
Route::post('storage/create', 'App\Http\Controllers\StorageController@store');
Route::delete('storage/delete', 'App\Http\Controllers\StorageController@delete')->name('delete');


Route::get('home', function () {
    //
})->name('home');

Route::get('profile/edit', function () {
    //
})->name('profile.edit');



