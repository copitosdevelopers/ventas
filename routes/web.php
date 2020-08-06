<?php

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

Route::get('/main', function () {
    return view('app');
})->name('main');

Route::get('categoria/listar','CategoriaController@listarCategorias');
Route::post('categoria/crear','CategoriaController@crearCategorias');
Route::put('categoria/actualizar/{id}','CategoriaController@actualizarCategorias');
Route::put('categoria/desactivar/{id}','CategoriaController@desactivarCategoria');
Route::put('categoria/activar/{id}','CategoriaController@activarCategoria');

Route::get('personas/listar','PersonasController@listarPersonas');
Route::post('personas/crear','PersonasController@crearPersonas');
Route::put('personas/actualizar/{id}','PersonasController@actualizarPersonas');
Route::put('personas/desactivar/{id}','PersonasController@desactivarPersonas');
Route::put('personas/activar/{id}','PersonasController@activarPersonas');
Route::get('personas/selectPersona','PersonasController@selectPersona');

Route::get('proveedores/listar','ProveedoresController@listarProveedores');
Route::post('proveedores/crear','ProveedoresController@crearProveedor');
Route::put('proveedores/actualizar/{id}','ProveedoresController@actualizarProveedor');
Route::put('proveedores/desactivar/{id}','ProveedoresController@desactivarProveedor');
Route::put('proveedores/activar/{id}','ProveedoresController@activarProveedor');

Route::get('articulo/listar','ArticuloController@listarArticulo');
Route::post('articulo/crear','ArticuloController@crearArticulo');
Route::put('articulo/actualizar/{id}','ArticuloController@actualizarArticulo');
Route::put('articulo/desactivar/{id}','ArticuloController@desactivarArticulo');
Route::put('articulo/activar/{id}','ArticuloController@activarArticulo');

Route::get('rol/listar','RolController@listarRols');
Route::post('rol/crear','RolController@crearRol');
Route::put('rol/actualizar/{id}','RolController@actualizarRol');
Route::put('rol/cambiarEstadoRol/{id}','RolController@cambiarEstadoRol');


Route::get('usuario/listar','UserController@listarUsuarios');
Route::post('usuario/registrar','UserController@store'); 
Route::put('usuario/actualizar/{id}','UserController@actualizarUser');
Route::put('usuario/activar/{id}','UserController@activarUsuario');
Route::put('usuario/desactivar/{id}','UserController@desactivarUsuario');

Route::get('/','Auth\LoginController@showLoginForm');
Route::post('/login','Auth\LoginController@login')->name('login');
Route::post('/logout','Auth\LoginController@logout')->name('logout');


Route::get('ingreso/listar','IngresoController@listarIngresos');
Route::post('ingreso/registrar','IngresoController@nuevoIngreso');
Route::put('ingreso/desactivar','IngresoController@desactivarIngreso');


Route::get('/home', 'HomeController@index')->name('home');
