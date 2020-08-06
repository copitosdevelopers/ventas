<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
Use App\User;
use App\Personas;
use Illuminate\Support\Facades\DB;

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

    public function store(Request $request)
    {   if(!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $personas = new Personas();
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

            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->estado ='1';
            $user->idrol= $request->idrol;
            $user->id = $personas->id;
            $user->save();

            DB::commit();

        } catch(Exception $e){
            DB::rollback();          
        }       
    }

    public function actualizarUser(Request $request){
        {   if(!$request->ajax()) return redirect('/');

            try{
                DB::beginTransaction();

                $usuario = User::findOrFail($request->id);
                $personas = Personas::findOrFail($usuario->id);    
                
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
    
                
                $usuario->usuario = $request->usuario;
                $usuario->password = bcrypt($request->password);
                $usuario->estado ='1';
                $usuario->idrol= $request->idrol;
                $usuario->id = $personas->id;
                $usuario->save();
    
                DB::commit();
    
            } catch(Exception $e){
                console.log(error);
                DB::rollback();          
            }       
        }
    }

    public function desactivarUsuario(Request $request, $id){
        $categoria = User::findOrFail($id);
        $categoria->estado='0';
        $categoria->save();
    }

    public function activarUsuario(Request $request, $id){
        $categoria = User::findOrFail($id);
        $categoria->estado='1';
        $categoria->save();
    }

}
