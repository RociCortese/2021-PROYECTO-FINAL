<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/', function () {

    return view('home');
});
Route::get('home', function () {
    //
})->name('home');

/*Chat*/
Route::post('/idInfo', 'App\Http\Controllers\Vendor\Chatify\MessagesController@idFetchData');
Route::post('sendMessage', 'App\Http\Controllers\Vendor\Chatify\MessagesController@send')->name('send.message');
Route::post('fetchMessages', 'App\Http\Controllers\Vendor\Chatify\MessagesController@fetch')->name('fetch.messages');
Route::get('/download/{fileName}', 'App\Http\Controllers\Vendor\Chatify\MessagesController@download')->name(config('chatify.attachments.download_route_name'));
Route::post('/chat/auth', 'App\Http\Controllers\Vendor\Chatify\MessagesController@pusherAuth')->name('pusher.auth');
Route::post('/makeSeen', 'App\Http\Controllers\Vendor\Chatify\MessagesController@seen')->name('messages.seen');
Route::post('/getContacts', 'App\Http\Controllers\Vendor\Chatify\MessagesController@getContacts')->name('contacts.get');
Route::post('/star', 'App\Http\Controllers\Vendor\Chatify\MessagesController@favorite')->name('star');
Route::post('/favorites', 'App\Http\Controllers\Vendor\Chatify\MessagesController@getFavorites')->name('favorites');
Route::post('/search', 'App\Http\Controllers\vendor\Chatify\MessagesController@search')->name('search');
Route::post('/shared', 'App\Http\Controllers\Vendor\Chatify\MessagesController@sharedPhotos')->name('shared');
Route::post('/deleteConversation', 'App\Http\Controllers\Vendor\Chatify\MessagesController@deleteConversation')->name('conversation.delete');
Route::post('/updateSettings', 'App\Http\Controllers\Vendor\Chatify\MessagesController@updateSettings')->name('avatar.update');

Route::post('/setActiveStatus', 'App\Http\Controllers\Vendor\Chatify\MessagesController@setActiveStatus')->name('activeStatus.set');

/*Perfil de usuario*/

Route::get('profile/edit', 'App\Http\Controllers\Auth\ProfileController@index')->name('profile.edit');
Route::put('profile/actualizar', 'App\Http\Controllers\Auth\ProfileController@updatepersonal')->name('profile.updatepersonal');
Route::put('profile/editar', 'App\Http\Controllers\Auth\ProfileController@updatecontra')->name('profile.updatecontra');

/*P??gina principal*/
Auth::routes();
Route::get('/directivo', 'App\Http\Controllers\DirectivoController@index')->name('directivo')->middleware('directivo');
Route::get('/docente', 'App\Http\Controllers\DocenteController@index')->name('docente')->middleware('docente');
Route::get('/familia', 'App\Http\Controllers\FamiliaController@index')->name('familia')->middleware('familia');

/*Verificaci??n de email*/
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
Route::get('configuraciones', 'App\Http\Controllers\ConfiguracionesController@index')->name('configuraciones');
Route::post('configuraciones/create', 'App\Http\Controllers\ConfiguracionesController@store')->name('confi');

/*Carga de docentes*/
Route::resource('admin/docentes','App\Http\Controllers\CargaDocenteController');
Route::get('admin/{id}/ver', 'App\Http\Controllers\CargaDocenteController@show')->name('ver');
Route::delete('admin/{id}/destroydoc', 'App\Http\Controllers\CargaDocenteController@destroy')->name('destroydoc');
Route::get('admin/{id}/editardoc', 'App\Http\Controllers\CargaDocenteController@editardoc')->name('editardocente');
Route::put('admin/{id}', 'App\Http\Controllers\CargaDocenteController@update')->name('docentes.update');


/*Carga de alumnos*/
Route::resource('admin/alumnos','App\Http\Controllers\CargaAlumnoController');
Route::get('admin/{id}/show', 'App\Http\Controllers\CargaAlumnoController@showalumnos')->name('show');
Route::get('admin/{id}/showfam', 'App\Http\Controllers\CargaAlumnoController@showfamilia')->name('showfam');
Route::delete('admin/{id}', 'App\Http\Controllers\CargaAlumnoController@destroy')->name('destroy');
Route::get('admin/{id}/editaralu', 'App\Http\Controllers\CargaAlumnoController@editaralumno')->name('editaralumno');
Route::post('admin/familia', 'App\Http\Controllers\CargaAlumnoController@crearfamilia')->name('crearfamilia');
Route::put('admin/{id}', 'App\Http\Controllers\CargaAlumnoController@updatealu')->name('updatealu');
Route::get('admin/{id}/editarfam', 'App\Http\Controllers\CargaFamiliaController@editarfamilia')->name('editarfam');
Route::put('admin/{id}', 'App\Http\Controllers\CargaFamiliaController@updatefamilia')->name('actualizarfam');

/*Creaci??n de a??o escolar*/
Route::get('a??oescolar', 'App\Http\Controllers\A??oController@index')->name('a??oescolar');
Route::get('a??oescolar/create', 'App\Http\Controllers\A??oController@create')->name('a??ocreate');
Route::post('a??oescolar/store', 'App\Http\Controllers\A??oController@store')->name('a??oescolar.store');
Route::get('armadogrado', 'App\Http\Controllers\A??oController@listadogrado')->name('armadogrado');
Route::post('armadogrado/buscar', 'App\Http\Controllers\A??oController@buscar')->name('buscar');
Route::get('armadogrado/create', 'App\Http\Controllers\A??oController@creategrado')->name('armadogrado.create');
Route::post('armadogrado/store', 'App\Http\Controllers\A??oController@armadogrado')->name('armadogrado.store');
Route::delete('a??oescolar/{id}', 'App\Http\Controllers\A??oController@destroy')->name('eliminara??o');
Route::get('a??oescolar/{id}/editara??o', 'App\Http\Controllers\A??oController@editara??o')->name('editara??o');
Route::put('a??oescolar/{id}', 'App\Http\Controllers\A??oController@actualizara??o')->name('actualizara??o');
Route::get('a??oescolar/{id}/estado', 'App\Http\Controllers\A??oController@actualizarestado')->name('actualizarestado');
Route::post('a??oescolar/especiales/{id}', 'App\Http\Controllers\A??oController@armadoespeciales')->name('armado.especiales');
Route::get('armadogrado/{id}/editargrado', 'App\Http\Controllers\A??oController@editargrado')->name('editargrado');
Route::put('armadogrado/{id}', 'App\Http\Controllers\A??oController@actualizargrado')->name('actualizargrado');


Route::get('/autocomplete/getAutocomplete/','App\Http\Controllers\ControllerEvent@getAutocomplete')->name('Autocomplte.getAutocomplte');
Route::get('/autocomplete/divisiones/','App\Http\Controllers\ConfiguracionesController@getAutocompletedivisiones')->name('Autocomplte.divisiones');
Route::get('/autocomplete/espacioscurriculares/','App\Http\Controllers\ConfiguracionesController@getAutocompleteespacios')->name('Autocomplte.espacios');


/*Calendario de eventos.*/
// formulario
Route::get('evento/form','App\Http\Controllers\ControllerEvent@form')->name('form');
Route::post('Evento/create','App\Http\Controllers\ControllerEvent@create');
Route::get('Eventos/listado','App\Http\Controllers\ControllerEvent@listadofamilias')->name('eventosfamilia');


Route::delete('evento/{id}/deletevento', 'App\Http\Controllers\ControllerEvent@destroy')->name('deletevento');

// Detalles de evento

Route::get('Evento/form','App\Http\Controllers\ControllerEvent@form');
Route::post('Evento/create','App\Http\Controllers\ControllerEvent@create');

Route::get('Evento/details/{id}','App\Http\Controllers\ControllerEvent@details');
Route::get('Evento/index','App\Http\Controllers\ControllerEvent@index')->name('calendario');
Route::get('Evento/index/{month}','App\Http\Controllers\ControllerEvent@index_month');
Route::post('Evento/calendario','App\Http\Controllers\ControllerEvent@calendario');
Route::get('Evento/{id}/editarevento', 'App\Http\Controllers\ControllerEvent@editarevento')->name('editarevento');
Route::put('Evento/{id}', 'App\Http\Controllers\ControllerEvent@actualizarevento')->name('actualizarevento');
