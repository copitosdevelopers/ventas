<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ingreso;
use App\DetalleIngreso;

class IngresoController extends Controller
{   
    

    public function listarIngresos(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->join('users','ingresos.idusuario','=','users.id')
        ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante','ingresos.num_comprobante',
                'ingresos.fecha_hora','ingresos.impuesto', 'ingresos.total',
                'ingresos.estado','personas.nombres','users.usuario')     
        ->orderBy('ingresos.id','desc')->get();
        return $ingresos;
    }

    public function nuevoIngreso(Request $request)
    {   if(!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $mytime = Carbon::now('America/Lima');

            $ingreso = new Ingreso();
            $ingreso->idproveedor = 24;
            //$ingreso->idproveedor = $request->idproveedor;
            $ingreso->idusuario = \Auth::user()->id;
            $ingreso->tipo_comprobante = $request->tipo_comprobante;
            $ingreso->serie_comprobante = $request->serie_comprobante;
            $ingreso->num_comprobante = $request->num_comprobante;
            $ingreso->fecha_hora = $mytime->toDateString();
            $ingreso->impuesto = $request->impuesto;
            $ingreso->total = 48;
            //$ingreso->total = $request->total;
            $ingreso->estado = 'Registrado';
            $ingreso->save();                    

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->id;
                $detalle->idarticulo = $det['idarticulo']; 
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];          
                $detalle->save();
            } 

            DB::commit();

        } catch(Exception $e){
            DB::rollback();          
        }       
    }

     
    public function desactivarIngreso(Request $request, $id){
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->estado='Anulado';
        $ingreso->save();
    }
 
}
