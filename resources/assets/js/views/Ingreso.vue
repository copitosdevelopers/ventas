<template>
  <div class="card mt-2" >
              <div class="card-header">
                <h3 class="card-title">Lista de Ingresos </h3>                    
                  <button type="button" class="btn btn-outline-primary btn-sm float-right" 
                          data-toggle="modal" data-target="#modal-lg" 
                          @click="abrirModal('ingreso','nuevo')">
                          Nuevo <i class="fas fa-plus"></i>
                  </button>
              </div>
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
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal-lg" @click="abrirModal('ingreso','actualizar',ingreso)">
                               <i class="fas fa-eye"></i>
                            </button>&nbsp;
                            <button v-if="ingreso.estado=='Registrado'" type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#modal-lg" @click="desactivarIngreso('ingreso','actualizar',ingreso)">
                               <i class="fas fa-edit"></i>
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

              <div class="card-body p-0 table-responsive">
                <form class="form-horizontal">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Proveedor</label>
                    <div class="col-sm-5">
                      
                      <select class="form-control select2" id="proveedores" >    
                          <option selected disabled>Buscar y seleccionar Proveedor</option>                    
                          <option v-for="proveedor in proveedores" 
                              :key="proveedor.id"  
                              :value="proveedor.id">
                              {{ proveedor.nombres }}
                          </option>
                          
                    </select>
                    
                    </div>
                     <label for="inputEmail3" class="col-sm-2 col-form-label">Impuesto</label>
                    <div class="col-sm-3">
                      <input v-model="impuesto" type="text" class="form-control" placeholder="Nombre">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Tipo Comprobante</label>
                    <div class="col-sm-2">
                      <input v-model="tipo_comprobante" type="text" class="form-control" placeholder="Nombre">
                    </div>
                     <label for="inputEmail3" class="col-sm-2 col-form-label">Serie Comprobante</label>
                    <div class="col-sm-2">
                      <input v-model="serie_comprobante" type="text" class="form-control" placeholder="Nombre">
                    </div>
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nro Comprobante</label>
                    <div class="col-sm-2">
                      <input v-model="num_comprobante" type="text" class="form-control" placeholder="Nombre">
                    </div>
                  </div>   

                   <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-1 col-form-label">Articulo</label>
                    <div class="col-sm-2">
                      <input v-model="idarticulo" type="text" class="form-control" placeholder="Nombre">
                    </div>
                     <label for="inputEmail3" class="col-sm-1 col-form-label">Precio</label>
                    <div class="col-sm-2">
                      <input v-model="precio" type="text" class="form-control" placeholder="Nombre">
                    </div>
                    <label for="inputEmail3" class="col-sm-1 col-form-label">Cantidad</label>
                    <div class="col-sm-2">
                      <input v-model="cantidad" type="text" class="form-control" placeholder="Nombre">
                    </div>
                    <div class="col-sm-2">
                      <button   type="button" 
                                class="btn btn-outline-success btn-sm float-right"
                                @click="nuevoIngreso()">
                                Agregar <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div> 
              
                    <pre>{{dataIngreso}}</pre>
                 </div>              
              </form>
              </div>  
      <!--<div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">{{titulo_modal}}</h3>
              </div>
             
        
              <form class="form-horizontal">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                      <input v-model="nombres" type="text" class="form-control" placeholder="Nombre">
                    </div>
                  </div>
                 
 
                </div>
                
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <button v-if="accion==1" type="button" class="btn btn-primary" data-dismiss="modal" @click="nuevoUsuario()">{{titulo_accion}}</button>
              <button v-else type="button" class="btn btn-primary" data-dismiss="modal" @click="actualizarUsuario()">{{titulo_accion}}</button>
            </div>
          </div>          
        </div>         
      </div>-->
   </div> 
</template>

<script>
export default {
    mounted (){
        this.listarIngresos();
        this.listarRoles();
        this.listarProveedores();

        $(document).ready(function() {       
        $(".select2").select2();
        $('#proveedores').on('select2:select', function (e) {
            let app = this;
             app.idProveedor = e.params.data.id;          
            console.log(app.idProveedor);
        }); 
      }); 

    },
    data(){
        return {
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
            arrayIngreso: [],
            arrayDetalle: [],  
            titulo_modal : '',
            titulo_accion:'',
            accion:'',
            idProveedor: null,
            dataIngreso: {}, 
        }
    }, 
    methods : {      
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
        desactivarUsuario(id){
          Vue.swal({
                    title: 'Estas seguro de desactivar este Usuario?',
                    //text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si Desactivar!'
                    }).then((result) => {
                      if (result.value) {
            let url ='usuario/desactivar/';
            axios.put(url+id)
            .then(respose=>{
                this.listarUsuarios();
                Vue.swal(
                        'Desactivado',
                        'Usuario Desactivado con Exito',
                        'success'
                     )
            })
            .catch(error=>console.log(error))
                }
            })
        },
        activarUsuario(id){
          Vue.swal({
                    title: 'Estas seguro de activar este Usuario?',
                    //text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si Activar!'
                    }).then((result) => {
                      if (result.value) {
            let url ='usuario/activar/';
            axios.put(url+id)
            .then(respose=>{
              Vue.swal(
                        'Activado',
                        'Usuario Activado con Exito',
                        'success'
                     )
                this.listarUsuarios();
            })
            .catch(error=>console.log(error))
             }
          })
        },
        listarRoles(){
                let url ='rol/listar';
                axios.get(url)
                .then(response=>{
                    this.arrayRol  = response.data;                  
                    
                })
                .catch(erros=>console.log(error))
        },
        selectProveedor(){
          
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
              'tipo_comprobante' : this.tipo_comprobante,
              'serie_comprobante' : this.serie_comprobante,
              'num_comprobante' : this.num_comprobante,
              'impuesto' : this.impuesto,
              'idarticulo' : this.idarticulo,
              'cantidad' : this.cantidad,
              'precio' : this.precio
            })
            .then(response=>{
                this.listarIngresos();         
            })
            .catch(error=>console.log(error));
        },
        actualizarUsuario(){
            
            let url ='usuario/actualizar/';
            axios.put(url+this.id_usuario,{
                'nombres' : this.nombres,
                'apellidos' : this.apellidos,
                'tipo_documento':  this.tipo_documento,
                'nro_documento': this.nro_documento,
                'direccion': this.direccion,
                'correo': this.correo,
                'telefono': this.telefono,
                'contacto':this.contacto,
                'telefono_contacto': this.telefono_contacto,
                'usuario': this.usuario,
                'password': this.password,
                'idrol': this.idrol
            })
            .then(response=>{
              Vue.swal(
                               'Actualizado',
                               'Usuario Actualizado con Exito',
                               'success'
                           )
                this.listarUsuarios();            
            })
            .catch(error=>console.log(error));
             
        },
        abrirModal(titulo, accion , data = []){
            switch(titulo){
                case 'ingreso':{
                    switch (accion){
                        case 'nuevo':{
                              this.id_usuario='',
                              this.titulo_modal ='Registrar Ingreso';
                              this.titulo_accion = 'Guardar';
                              this.accion='1';                              
                              this.nombres='';
                              this.apellidos='';
                              this.tipo_documento='';
                              this.nro_documento='';
                              this.direccion='';
                              this.correo='';
                              this.telefono='';
                              this.usuario='';
                              this.idrol = '';
                              this.usuario='';
                              break;
                        }
                        case 'ingreso':{
                              this.titulo_modal ='Actualizar Usuario';
                              this.titulo_accion = 'Actualizar'; 
                              this.accion='2';                             
                              this.nombres=data['nombres'];
                              this.apellidos=data['apellidos'];
                              this.tipo_documento=data['tipo_documento'];
                              this.nro_documento=data['nro_documento'];
                              this.direccion=data['direccion'];
                              this.correo=data['correo'];
                              this.telefono=data['telefono'];                             
                              this.id_usuario=data['id'];
                              this.idrol = data ['idrol'];
                              this.usuario = data['usuario'];
                              this.password = data['password'];
                              break; 
                        }
                    }
                }
            }
        }


    }
}
</script>
 