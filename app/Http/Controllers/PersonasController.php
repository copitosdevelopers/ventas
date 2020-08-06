<?php

namespace App\Http\Controllers;

use App\Personas;
use Illuminate\Http\Request;

class PersonasController extends Controller
{
    public function listarPersonas(Request $request){
        //if(!$request->ajax()) return redirect('/');
        //$categorias = Categoria::where('estado','=','1')
        //->orderBy('nombre','asc'); 
        $personas = Personas::all();
        
        return $personas;
    }

    public function crearPersonas (Request $request){
        $personas = new Personas();
        $personas->nombres = $request->nombres;
        $personas->apellidos = $request->apellidos;
        $personas->tipo_documento = $request->tipo_documento;
        $personas->nro_documento = $request->nro_documento;
        $personas->direccion = $request->direccion;
        $personas->correo = $request->correo;
        $personas->telefono = $request->telefono;
        $personas->usuario =\Auth::user()->id;
        $personas->estado = "1";
        $personas->save();
        return $personas;
    }

    public function actualizarPersonas (Request $request, $id ){
        $personas = Personas::findOrFail($id);
        $personas->nombres = $request->nombres;
        $personas->apellidos = $request->apellidos;
        $personas->tipo_documento = $request->tipo_documento;
        $personas->nro_documento = $request->nro_documento;
        $personas->direccion = $request->direccion;
        $personas->correo = $request->correo;
        $personas->telefono = $request->telefono;
        $personas->usuario = \Auth::user()->id;
        $personas->estado = "1";
        $personas->save();
        return $personas;
    }

    public function desactivarPersonas(Request $request, $id){
        $personas = Personas::findOrFail($id);
        $personas->estado='0';
        $personas->save();
    }

    public function activarPersonas(Request $request, $id){
        $personas = Personas::findOrFail($id);
        $personas->estado='1';
        $personas->save();
    }
}
