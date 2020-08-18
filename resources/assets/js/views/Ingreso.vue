<template>
  <div class="card mt-2" >
              <div class="card-header">
                <h3 class="card-title"><b>{{titulo_ingreso}}</b> </h3>                    
                  <button v-show="listado==1" type="button" class="btn btn-outline-primary btn-sm float-right"                          
                          @click="mostrarDetalle()">
                          Nuevo <i class="fas fa-plus"></i>
                  </button>
              </div>
              <template v-if="listado==1">
                 <div class="card-body p-0 table-responsive">
                  <table class="table table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Opciones</th>
                      <th>Usuario </th>
                      <th>Proveedor</th>
                      <th>T. Comprobante </th>
                      <th>S. Comprobante</th>
                      <th>Nro. Comprobante</th> 
                      <th>Fecha Hora</th>  
                      <th>total</th>  
                      <th>Impuestos</th>  
                      <th>Estado</th>   
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(ingreso, index) in arrayIngreso " :key="ingreso.id">
                      <td>{{index+1}}</td>
                      <td>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg" @click="verIngreso(ingreso.id)">
                               <i class="fas fa-eye"></i>
                            </button>&nbsp;
                            <button v-if="ingreso.estado=='Registrado'" type="button" class="btn btn-danger btn-sm" @click="anularIngreso(ingreso.id)">
                               <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                        <td>{{ingreso.usuario}}</td>
                        <td>{{ingreso.nombres}}</td>
                        <td>{{ingreso.tipo_comprobante}}</td>  
                        <td>{{ingreso.serie_comprobante}}</td>       
                        <td>{{ingreso.num_comprobante}}</td>  
                        <td>{{ingreso.fecha_hora}}</td>      
                        <td>{{ingreso.total}}</td>
                        <td>{{ingreso.impuesto}}</td>
                        <td>{{ingreso.estado}}</td>
                      </tr>                 
                    </tbody>
                  </table>
                </div>
              </template>
              
              <template v-else>
                 <div class="card-body p-0 table-responsive">
                <form class="form-horizontal">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Proveedor</label>
                    <div class="col-sm-4">                      
                      <select class="form-control select2" id="proveedores" v-model="idProveedor">    
                          <option selected disabled>Buscar y seleccionar Proveedor</option>                    
                          <option v-for="proveedor in proveedores" 
                              :key="proveedor.id"  
                              :value="proveedor.id">
                              {{ proveedor.nombres }}
                          </option>
                          
                    </select>
                    
                    </div>
                     <label class="col-sm-2 col-form-label">Impuesto</label>
                    <div class="col-sm-2">
                      <input v-model="impuesto" type="text" class="form-control" placeholder="Nombre">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tipo Comprobante</label>
                    <div class="col-sm-2">
                    
                      <select   v-model="tipo_comprobante" class="form-control">
                        <option value="0">Seleccione</option>
                        <option value="BOLETA">Boleta</option>
                        <option value="FACTURA">Factura</option>
                        <option value="TICKET">Ticket</option>
                      </select>
                    </div>
                     <label class="col-sm-2 col-form-label">Serie Comprobante</label>
                    <div class="col-sm-2">
                      <input v-model="serie_comprobante" type="text" class="form-control">
                    </div>
                    <label class="col-sm-2 col-form-label">Nro Comprobante</label>
                    <div class="col-sm-2">
                      <input v-model="num_comprobante" type="text" class="form-control">
                    </div>
                  </div>   

                   <div class="form-group row">
                    <label class="col-sm-1 col-form-label">Articulo <span v-show="idarticulo==0" style="color:red;">*</span></label>
                    <div class="col-sm-2">
                      <input v-model="codigo" @keyup.enter="buscarArticulo()" type="text" class="form-control" placeholder="codigo">
                      
                     
                      <!--<select class="form-control select2 articulo" v-model="idarticulo">    
                          <option selected disabled> seleccionar Articulo</option>                    
                          <option v-for="articulo in articulos" 
                              :key="articulo.id"  
                              :value="articulo.id">
                              {{ articulo.nombre }}
                          </option>                          
                      </select>-->
                      </div>
                    <div class="col-sm-1">
                          <button class="btn btn-primary" data-toggle="modal" data-target="#modal-detalle">...</button>
                    </div>
                    <div class="col-sm-2">
                          <input   type="text" readonly class="form-control" v-model="articulo">
                    </div>


                     <label class="col-sm-1 col-form-label">Precio <span v-show="precio==0" style="color:red;">*</span></label>
                    <div class="col-sm-2">
                      <input v-model="precio" type="text" class="form-control">
                    </div>
                    <label class="col-sm-1 col-form-label">Cantidad<span v-show="cantidad==0" style="color:red;">*</span></label>
                    <div class="col-sm-2">
                      <input v-model="cantidad" type="text" class="form-control">
                    </div>
                    
                  </div>
                  
                  <div class="form-group row">
                    <div class="col-sm-2">
                      <button   type="button" 
                                class="btn btn-success form-control"
                                @click="agregarDetalle()">
                                Agregar <i class="fas fa-plus"></i>
                      </button>
                    </div>
                     
                  </div>

              <div class="form-group row">
                <div class="card-body p-0 table-responsive">
                  <table class="table table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Opciones</th>
                      <th>Articulo </th>
                      <th>Precio</th>
                      <th>Cantidad </th>
                      <th>Subtotal</th>                       
                    </tr>
                  </thead>
                  <tbody v-if="arrayDetalle.length">
                    <tr v-for="(detalle,index ) in arrayDetalle" :key="detalle.id">  
                        <td>{{index+1}}</td>                     
                        <td>                            
                          <button  type="button" class="btn btn-outline-warning btn-sm" @click="eliminarDetalle(index)" >
                            <i class="far fa-trash-alt"></i>
                          </button>
                        </td>
                        <td>{{detalle.articulo}}</td>
                        <td>{{detalle.precio}}</td>
                        <td>{{detalle.cantidad}}</td>  
                        <td>{{detalle.precio*detalle.cantidad}}</td>     
                    </tr>
                    <tr style="background-color:#CEECF5">
                        <td colspan="5" align="right"><strong>Total Parcial: </strong></td>
                        <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                    </tr>
                    <tr style="background-color:#CEECF5">
                        <td colspan="5" align="right"><strong>Total Impuesto: </strong></td>
                        <td>$ {{totalImpuesto=((total*impuesto)/1+impuesto).toFixed(2)}}</td>
                    </tr>
                    <tr style="background-color:#CEECF5">
                        <td colspan="5" align="right"><strong>Total: </strong></td>
                        <td>$ {{total=calcularTotal}}</td>
                    </tr>                                    
                  </tbody>
                  <tbody v-else>
                          <tr>
                              <td colspan="5" class="text-center">No existe Articulos</td>
                          </tr>    
                  </tbody>
                  </table>
                </div>
              
              </div>
              <div class="form-group row">
                 <div class="col-sm-2">
                  <button   type="button" 
                                class="btn btn-danger form-control"
                                @click="ocultarDetalle()">
                                Cerrar <i class="fas fa-reply"></i>
                  </button>
                 </div>
                  <div class="col-sm-3">
                  <button   type="button" class="btn btn-success form-control" @click="nuevoIngreso()">
                            Registrar Compra <i class="fas fa-truck"></i>
                  </button>
                 </div>
               </div> 
            </div>              
          </form>
        </div>  
      </template> 
              
      <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Detalles del Ingreso</h3>
              </div>                    
              <div class="card-body p-0 table-responsive">
                  <table class="table table-sm">
                  <thead>
                    <tr>                      
                      <th>Proveedor</th>
                      <th>Impuesto </th>
                      <th>Tipo Comprobante</th>
                      <th>Serie Comprobante</th>
                      <th>Nro Comprobante</th>                          
                    </tr>
                  </thead>
                  <tbody>
                    <tr>                      
                        <td>{{proveedor}}</td>
                        <td>{{impuesto}}</td>
                        <td>{{tipo_comprobante}}</td>  
                        <td>{{serie_comprobante}}</td>       
                        <td>{{num_comprobante}}</td>                      
                    </tr>                 
                    </tbody>
                  </table>
                </div>

                <div class="card-body p-0 table-responsive">
                  <table class="table table-sm">
                  <thead>
                    <tr>                      
                      <th>Articulos</th>
                      <th>Precio</th>
                      <th>Cantidad</th>
                      <th>Sub total</th>                        
                    </tr>
                  </thead>
                  <tbody v-if="arrayDetalle.length">
                    <tr v-for="detalle in arrayDetalle" :key="detalle.id">                      
                        <td>{{detalle.articulo}}</td>
                        <td>{{detalle.precio}}</td>
                        <td>{{detalle.cantidad}}</td>  
                        <td>{{detalle.precio*detalle.cantidad}}</td>                        
                    </tr>   
                     <tr style="background-color:#CEECF5">
                        <td colspan="3" align="right"><strong>Total Parcial: </strong></td>
                        <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                    </tr>
                    <tr style="background-color:#CEECF5">
                        <td colspan="3" align="right"><strong>Total Impuestos: </strong></td>
                        <td>$ {{totalImpuesto=((total*impuesto)).toFixed(2)}}</td>
                    </tr>
                    <tr style="background-color:#CEECF5">
                        <td colspan="3" align="right"><strong>Total: </strong></td>
                        <td>$ {{total}}</td>
                    </tr>            
                    </tbody>
                    <tbody v-else>
                        <tr>
                          <td colspan="5">No existe Articulos</td>
                        </tr>    
                    </tbody>
                  </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               
            </div>
          </div>          
        </div>         
      </div>
      <div class="modal fade" id="modal-detalle">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Buscar Articulo</h3>
              </div>
                <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="input-group">
                            
                            <input type="text" v-model="buscar" @keyup.enter="buscarArticuloModal(buscar)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="buscarArticuloModal(buscar)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                </div>
        

                <div class="card-body p-0 table-responsive">
                  <table class="table table-sm">
                  <thead>
                    <tr>     
                      <th>Opciones</th>                 
                      <th>Articulo</th>
                      <th>Precio</th>
                      <th>categoria</th>
                      <th>Stock</th>                        
                    </tr>
                  </thead>
                  <tbody v-if="arrayArticulo.length">
                    <tr v-for="articulo in arrayArticulo" :key="articulo.id"> 
                        <td>
                          <button type="button" class="btn btn-primary btn-sm"  >
                              <i class="fas fa-truck"></i>
                            </button>
                        </td>                     
                        <td>{{articulo.nombre}}</td>
                        <td>{{articulo.precio}}</td>
                        <td>{{articulo.nombre_categoria}}</td>  
                        <td>{{articulo.stock}}</td>                        
                    </tr>   
                                
                    </tbody>
                    <tbody v-else>
                        <tr>
                          <td colspan="5" class="text-center">No existen Articulos</td>
                        </tr>    
                    </tbody>
                  </table>
                </div>


            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               
            </div>
          </div>          
        </div>         
      </div>
   </div> 
</template>

<script>
export default {
    mounted (){
        this.listarIngresos(); 
        this.listarProveedores();        
        this.listarArticulo();
       
    },
    data(){
        return {
            buscar:'',
            titulo_ingreso : 'Listado de Ingresos',
            articulos : [],
            proveedores : [],
            ingreso_id :0,
            idarticulo:'',
            precio: '',
            cantidad: '',
            nombres:'',
            tipo_comprobante:'Boleta',
            serie_comprobante:'',
            num_comprobante:'',
            impuesto: 0.18,
            total: 0.0, 
            totalImpuesto :0.0,
            totalParcial: 0.0,
            arrayIngreso: [],
            arrayDetalle: [],  
            titulo_modal : '',
            titulo_accion:'',
            accion:'',
            idProveedor: null,
            dataIngreso: {}, 
            listado :1,
            proveedor : '',
            articulo: '',
            arrayArticulo :[],
            codigo :''
            
          
        }
    }, 
    computed: {
      calcularTotal: function (){
        var resultado =0.0;
        for(var i=0; i<this.arrayDetalle.length; i++){
          resultado = resultado + (this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
        }
        return resultado;
      }
    },
    methods : {  
        buscarArticuloModal( buscar ){
                let app = this;
                let url = '/articulo/buscarArticuloModal?buscar='+ buscar;
                axios.get(url)
                .then(response=>{
                    var respuesta = response.data;
                    app.arrayArticulo=respuesta.articulos.data;
                    console.log(app.arrayArticulo);                    
                })
                .catch(error=>console.log(error));
            },       
        buscarArticulo(){
               var url ='/articulo/buscarArticulo?filtro='+this.codigo;
               axios.get(url)
               .then(response=>{
                   var respuesta = response.data;
                   this.arrayArticulo = respuesta.articulos;
                   
                   if(this.arrayArticulo.length>0){
                       this.articulo=this.arrayArticulo[0]['nombre'];
                       this.idarticulo=this.arrayArticulo[0]['id'];
                   } 
                   else {
                       this.articulo ="No existe articulo";
                       this.idarticulo=0;
                   }

               })
               .catch(error=>(console.log(error)))
            }, 
      verIngreso(id){
        var arrayIngresoT=[];
        var url='/ingreso/obtenerCabecera?id='+id;
        axios.get(url)
        .then(response=>{
          var respuesta = response.data;
          arrayIngresoT= respuesta.ingreso;

          this.proveedor = arrayIngresoT[0]['nombres'];
          this.impuesto = arrayIngresoT[0]['impuesto'];
          this.tipo_comprobante = arrayIngresoT[0]['tipo_comprobante'];
          this.serie_comprobante = arrayIngresoT[0]['serie_comprobante'];
          this.num_comprobante = arrayIngresoT[0]['num_comprobante'];
          this.total = arrayIngresoT[0]['total'];
        })
        .catch(error=>console.log(error));

        var urld = '/ingreso/obtenerDetalles?id='+id;
        axios.get(urld)
        .then(response=>{
              var respuesta= response.data;
              this.arrayDetalle=respuesta.detalles;   
              console.log( this.arrayDetalle);                 
        })
        .catch(error=>console.log(error));
      }, 
       eliminarDetalle(index){
                this.arrayDetalle.splice(index,1);
      },
      listarArticulo(){
            let url ='articulo/listar';
            axios.get(url)
            .then(response=>{
                this.articulos = response.data;
            })
            .catch(error=>console.log(error))
        },   
        listarProveedores(){
            let url ='proveedores/listar';
            axios.get(url)
            .then(response=>{
                this.proveedores = response.data;
                console.log(this.proveedores);
            })
            .catch(error=>console.log(error))
        },
        listarIngresos(){
            let url ='ingreso/listar';
            axios.get(url)
            .then(response=>{
                this.arrayIngreso = response.data;
            })
            .catch(error=>console.log(error))
        },
        anularIngreso(id){
          Vue.swal({
                    title: 'Estas seguro de anular este Ingreso?',
                    //text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Anular!'
                    }).then((result) => {
                      if (result.value) {
            let url ='ingreso/anular/';
            axios.put(url+id)
            .then(respose=>{
                this.listarIngresos();
                Vue.swal(
                        'Anulado',
                        'Ingreso Anulado con Exito',
                        'success'
                     )
            })
            .catch(error=>console.log(error))
                }
            })
        },
        nuevoIngreso(){
          let iddd = this.idProveedor;
          console.log(iddd);
            let app = this;
            let url ='ingreso/registrar';
           // app.dataIngreso.idproveedor = this.idProveedor;
            let nuevoIngreso = app.dataIngreso;
            console.log(nuevoIngreso);
            axios.post(url,{
              'idproveedor': this.idProveedor,
              'tipo_comprobante' : this.tipo_comprobante,
              'serie_comprobante' : this.serie_comprobante,
              'num_comprobante' : this.num_comprobante,
              'impuesto' : this.impuesto, 
              'total':this.total,
              'precio' : this.precio,
              'data' : this.arrayDetalle
            })
            .then(response=>{
                this.titulo_ingreso='Listado de Ingresos';
                this.listado=1;
                this.idProveedor=0;
                this.tipo_comprobante='BOLETA';
                this.serie_comprobante='';             
                this.num_comprobante='';
                this.impuesto=0.18;
                this.idarticulo=0;                     
                this.cantidad=0;
                this.precio=0;
                this.arrayDetalle=[];
                this.listarIngresos();         
            })
            .catch(error=>console.log(error));
        },
        agregarDetalle(){
          this.arrayDetalle.push({
            idarticulo:this.idarticulo,
            articulo: this.articulo,
            cantidad:this.cantidad,
            precio:this.precio,
            idProveedor: this.idProveedor
          });
          console.log(this.arrayDetalle);
            this.idarticulo=0;
            this.articulo='';
            this.cantidad=0;
            this.precio=0;
            this.codigo='';
        },
        mostrarDetalle(){
          this.titulo_ingreso='Registrando Ingreso';
          this.listado=0;
          this.total=0;
          /*$(document).ready(function() {       
          $(".select2").select2();
          $('#proveedores').on('select2:select', function (e) {
              let app = this;
              app.idProveedor = e.params.data.id;          
              console.log(app.idProveedor);
          }); 
          });*/
        },
        ocultarDetalle(){
          this.listado=1;
          this.titulo_ingreso='Listado de Ingresos';
          this.arrayDetalle = [];
        }
    }
}
</script>
 