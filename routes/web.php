<?php

use Illuminate\Support\Facades\Route;

/*Login*/
Route::get('/', function () {
    return view('auth/login');
});
Route::get('home', function () {
    //
})->name('home');

Route::get('profile/edit', 'App\Http\Controllers\Auth\ProfileController@index')->name('profile.edit');
Route::put('profile/edit', 'App\Http\Controllers\Auth\ProfileController@updatepersonal')->name('profile.updatepersonal');
Route::put('profile/editar', 'App\Http\Controllers\Auth\ProfileController@updatecontra')->name('profile.updatecontra');

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
Route::get('formulario', 'App\Http\Controllers\ColegioController@index')->name('formulario');
Route::post('storage/create', 'App\Http\Controllers\ColegioController@store');
Route::get('storage/{id}/editar', 'App\Http\Controllers\ColegioController@edit')->name('edit');
Route::put('storage/{id}', 'App\Http\Controllers\ColegioController@update')->name('update');


/*Carga de docentes*/
Route::resource('admin/docentes','App\Http\Controllers\CargaDocenteController');
Route::get('admin/{id}/ver', 'App\Http\Controllers\CargaDocenteController@show')->name('ver');
Route::delete('admin/{id}/destroydoc', 'App\Http\Controllers\CargaDocenteController@destroy')->name('destroydoc');
Route::get('admin/{id}/editardoc', 'App\Http\Controllers\CargaDocenteController@edit')->name('editardocente');
Route::put('admin/{id}', 'App\Http\Controllers\CargaDocenteController@update')->name('update');



/*Carga de alumnos*/
Route::resource('admin/alumnos','App\Http\Controllers\CargaAlumnoController');
Route::get('admin/{id}/show', 'App\Http\Controllers\CargaAlumnoController@showalumnos')->name('show');
Route::get('admin/{id}/showfam', 'App\Http\Controllers\CargaAlumnoController@showfamilia')->name('showfam');
Route::delete('admin/{id}', 'App\Http\Controllers\CargaAlumnoController@destroy')->name('destroy');
Route::get('admin/{id}/editaralu', 'App\Http\Controllers\CargaAlumnoController@editaralumno')->name('editaralumno');

Route::put('admin/{id}', 'App\Http\Controllers\CargaAlumnoController@updatealu')->name('updatealu');
Route::get('admin/{id}/editarfam', 'App\Http\Controllers\CargaFamiliaController@editarfamilia')->name('editarfam');
Route::put('admin/{id}', 'App\Http\Controllers\CargaFamiliaController@updatefamilia')->name('actualizarfam');

