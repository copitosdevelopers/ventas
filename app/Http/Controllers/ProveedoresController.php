<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Proveedores;
use App\Personas;
class ProveedoresController extends Controller
{   
    public function selectProveedor(Request $request){
        $proveedor = Proveedores::all();
        return $proveedor;
    }    

    public function listarProveedores(Request $request){
        $proveedor = Proveedores::join('personas','proveedores.id','=','personas.id')
        ->select('personas.nombres','personas.apellidos','personas.direccion','personas.correo','proveedores.contacto','proveedores.telefono_contacto','personas.tipo_documento', 'personas.nro_documento',
                'personas.telefono','personas.id','proveedores.id','personas.estado')
        //->select('personas.nombres','personas.apellido','personas.direccion')
        ->orderBy('personas.nombres','desc')->get();;
        //$proveedor = Proveedores::all();

        return $proveedor;
    }
 

    public function crearProveedor(Request $request){
        try{
            DB::beginTransaction();

            $persona = new Personas();
            $persona->nombres = $request->nombres;
            $persona->apellidos = $request->apellidos;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->nro_documento = $request->nro_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->correo = $request->correo;    
            $persona->usuario='1';
            $persona->save();

            $proveedor = new Proveedores();
            $proveedor->contacto = $request->contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            $proveedor->id= $persona->id;
            $proveedor->save();

            DB::commit();

        } catch(Exception $e){
            DB::rollback();
        }
    }

    public function actualizarProveedor(Request $request){
        try{
            DB::beginTransaction();

            $proveedor = Proveedores::findOrFail($request->id);
            $persona = Personas::findOrFail($proveedor->id);
             
            $persona->nombres = $request->nombres;
            $persona->apellidos = $request->apellidos;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->nro_documento = $request->nro_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->correo = $request->correo;    
            $persona->usuario='1';
            $persona->save();

            
            $proveedor->contacto = $request->contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            $proveedor->id= $persona->id;
            $proveedor->save();

            DB::commit();

        } catch(Exception $e){
            DB::rollback();
        }
    }

    public function desactivarProveedor(Request $request, $id){
        $proveedores = Personas::findOrFail($id);
        $proveedores->estado='0';
        $proveedores->save();
    }

    public function activarProveedor(Request $request, $id){
        $proveedores = Personas::findOrFail($id);
        $proveedores->estado='1';
        $proveedores->save();
    }

}
