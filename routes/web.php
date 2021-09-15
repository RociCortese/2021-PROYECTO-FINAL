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
Route::delete('storage/delete', 'App\Http\Controllers\ColegioController@delete')->name('delete');

/*Carga de docentes*/
Route::resource('admin/docentes','App\Http\Controllers\CargaDocenteController');

