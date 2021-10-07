<?php

use Illuminate\Support\Facades\Route;

/*Login*/
Route::get('/', function () {
    return view('auth/login');
});
Route::get('home', function () {
    //
})->name('home');

Route::get('profile/edit', function () {
    //
})->name('profile.edit');

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
Route::get('admin/{id}/editar', 'App\Http\Controllers\CargaDocenteController@edit')->name('edit');
Route::put('admin/{id}', 'App\Http\Controllers\CargaDocenteController@update')->name('update');



/*Carga de alumnos*/
Route::resource('admin/alumnos','App\Http\Controllers\CargaAlumnoController');
Route::get('admin/{id}/show', 'App\Http\Controllers\CargaAlumnoController@show')->name('show');
Route::delete('admin/{id}', 'App\Http\Controllers\CargaAlumnoController@destroy')->name('destroy');


/*Route::get('admin/{familia}/show', 'App\Http\Controllers\CargaFamiliaController@show')->name('show');*/


