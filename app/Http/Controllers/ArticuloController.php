<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use Illuminate\Support\Facades\DB;

class ArticuloController extends Controller
{
    public function listarArticulo(Request $request){
        //if(!$request->ajax()) return redirect('/');
        //$categorias = Categoria::where('estado','=','1')
        //->orderBy('nombre','asc');
        $articulos = DB::table('articulos')
        ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
        ->select('articulos.*', 'categorias.nombre as nombre_categoria')
        ->get();
        return $articulos;
    }

    public function crearArticulo (Request $request){
       $articulos = new Articulo();
        $articulos->codigo = $request->codigo;
        $articulos->nombre = $request->nombre;
        $articulos->precio = $request->precio;
        $articulos->stock = $request->stock;
        $articulos->descripcion = $request->descripcion;
        $articulos->estado = "1";
        $articulos->id_categoria = $request->id_categoria;
        $articulos->save();
        return $articulos;
    }

    public function actualizarArticulo (Request $request, $id ){
        $articulos = Articulo::findOrFail($id);
        $articulos->codigo = $request->codigo;
        $articulos->nombre = $request->nombre;
        $articulos->precio = $request->precio;
        $articulos->stock = $request->stock;
        $articulos->descripcion = $request->descripcion;
        $articulos->estado = "1";
        $articulos->id_categoria = $request->id_categoria;
        $articulos->save();
        return $articulos;
    }

    public function desactivarArticulo(Request $request, $id){
        $articulos = Articulo::findOrFail($id);
        $articulos->estado='0';
        $articulos->save();
    }

    public function activarArticulo(Request $request, $id){
        $articulos = Articulo::findOrFail($id);
        $articulos->estado='1';
        $articulos->save();
    }
}
