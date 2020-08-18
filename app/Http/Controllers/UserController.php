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
                'users.estado', 'users.idrol','rols.nombre as rol')     
        ->orderBy('personas.id','desc')->get();

      /*   $usuarios = [];
        foreach($user as $use){
            
            $usuarios[$use->pass] = \Illuminate\Support\Facades\Crypt::decrypt($use->pass);
        }
 */
        /* $string = 'c4ca4238a0b923820dcc';
        $encrypted = \Illuminate\Support\Facades\Crypt::encrypt($string);
        $decrypted_string = \Illuminate\Support\Facades\Crypt::decrypt($encrypted);

        var_dump($string); 
        var_dump($encrypted); 
        var_dump($decrypted_string); */

        
        return $user;
    }

    public function store(Request $request)
    {   if(!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();
              
            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->estado ='1';
            $user->idrol= $request->idrol;
            $user->id = $request->id;
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
                
                $usuario->usuario = $request->usuario;
                if($request->password){
                   $usuario->password = bcrypt($request->password); 
                }
                $usuario->estado ='1';
                $usuario->idrol= $request->idrol;
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
