<?php

namespace App\Http\Controllers;
Use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function listarUsuarios(Request $request){
        $user = User::join('personas','users.id','=','personas.id')
        ->join('rols','users.idrol','=','rols.id')
        ->select('personas.id','personas.nombres','personas.apellidos','personas.direccion',
                'personas.correo','personas.tipo_documento', 'personas.nro_documento',
                'personas.telefono','personas.estado','users.usuario','users.password',
                'users.estado','users.idrol','rols.nombre as rol')     
        ->orderBy('personas.id','desc')->get();
        return $user;
    }
}
