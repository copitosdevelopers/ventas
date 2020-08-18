<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use Illuminate\Support\Facades\DB;

class ArticuloController extends Controller
{   
    public function buscarArticuloModal(Request $request)
    {
       //if(!$request->ajax()) return redirect('/');

       $buscar = $request->buscar;
      
       if($buscar==''){
           $articulos = Articulo::join('categorias','articulos.id_categoria','=','categorias.id')
           ->select('articulos.id','articulos.id_categoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio','articulos.stock','articulos.descripcion','articulos.estado')
           ->orderBy('articulos.id','desc')->paginate(10);
       }
       else {
        $articulos = Articulo::join('categorias','articulos.id_categoria','=','categorias.id')
        ->select('articulos.id','articulos.id_categoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio','articulos.stock','articulos.descripcion','articulos.estado')
        ->where('articulos.nombre','like','%'.$buscar.'%')
        ->orderBy('articulos.id','desc')->paginate(10);
       }      
        return ['articulos' =>$articulos];         
    }

    public function buscarArticulo(Request $request){
        if(!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $articulos = Articulo::where('codigo','=',$filtro)
        ->select('id','nombre')->orderBy('nombre','asc')->take(1)->get();
        return ['articulos'=>$articulos];

    }

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
