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

Route::get('/', function () {
    return view('app');
});

Route::get('categoria/listar','CategoriaController@listarCategorias');
Route::post('categoria/crear','CategoriaController@crearCategorias');
Route::put('categoria/actualizar/{id}','CategoriaController@actualizarCategorias');
Route::put('categoria/desactivar/{id}','CategoriaController@desactivarCategoria');
Route::put('categoria/activar/{id}','CategoriaController@activarCategoria');