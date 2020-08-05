<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;

class RolController extends Controller
{

    public function listarRols()
    {
        
    
       $roles = Rol::all();        
       return $roles;

       /*$roles = Rol::where('estado','=','1')
        ->select('id','nombre')
        ->orderby('nombre','asc')->get();
        return ['roles' => $roles];*/
    }

    public function crearRol(Request $request)
    {

        $nuevoRol = new Rol();
        $nuevoRol->nombre        = $request->nombre; 
        $nuevoRol->slug          = "slug-standby"; 
        $nuevoRol->descripcion   = $request->descripcion; 
        $nuevoRol->estado        = "1"; 
        $nuevoRol->save();

        return $nuevoRol;

    }

    public function actualizarRol(Request $request, $id)
    {
        $actualizarRol = Rol::find($id);
        $actualizarRol->nombre        = $request->nombre; 
        $actualizarRol->slug          = "slug-standby"; 
        $actualizarRol->descripcion   = $request->descripcion; 
        $actualizarRol->estado        = "1"; 
        $actualizarRol->save();

        return $actualizarRol;

    }

    public function cambiarEstadoRol(Request $request, $id)
    {
        $estadoRol = Rol::find($id);

        if($estadoRol->estado == '1'){
            $estadoRol->estado = "0";
        }else{
            $estadoRol->estado = "1";
        }

        $estadoRol->save();
       
        return $estadoRol;
    }


    
}
