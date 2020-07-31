<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class CategoriaController extends Controller
{
    public function listarCategorias(Request $request){
        //if(!$request->ajax()) return redirect('/');
        //$categorias = Categoria::where('estado','=','1')
        //->orderBy('nombre','asc');
        $categorias = Categoria::all();
        
        return $categorias;
    }

    public function crearCategorias (Request $request){
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->usuario = $request->usuario;
        $categoria->estado = "1";
        $categoria->save();
        return $categoria;
    }

    public function actualizarCategorias (Request $request, $id ){
        $categoria = Categoria::findOrFail($id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->estado = "1";
        $categoria->save();
        return $categoria;
    }

    public function desactivarCategoria(Request $request, $id){
        $categoria = Categoria::findOrFail($id);
        $categoria->estado='0';
        $categoria->save();
    }

    public function activarCategoria(Request $request, $id){
        $categoria = Categoria::findOrFail($id);
        $categoria->estado='1';
        $categoria->save();
    }

}
