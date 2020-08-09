<template>
<!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Listado de Clientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Almacen</a></li>
              <li class="breadcrumb-item active">Clientes</li>
              <li class="breadcrumb-item">
                <button type="button" class="btn btn-outline-primary btn-sm float-right" data-toggle="modal" data-target="#modal-default" @click="abrirModal('personas','nuevo')">
                              Nuevo <i class="fas fa-plus"></i>
                </button>
              </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
             <!-- <div class="card-header">
                <h3 class="card-title">Listado de Personas</h3>
                <button type="button" class="btn btn-outline-primary btn-sm float-right" data-toggle="modal" data-target="#modal-default" @click="abrirModal('personas','nuevo')">
                              Nuevo <i class="fas fa-plus"></i>
                </button>
              </div>
               /.card-header -->
              <div class="card-body">
                <table id="tablita" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Apellidos y Nombres</th>
                    <th>Documento</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(personas, index) in personas " :key="personas.id">
                    <td>{{index+1}}</td>
                    <td>{{personas.apellidos}} {{personas.nombres}}</td>
                    <td>{{personas.tipo_documento}} - {{personas.nro_documento}}</td>
                    <td>{{personas.correo}}</td>
                    <td>{{personas.telefono}}</td>
                    <td>
                          <span v-if="personas.estado==1" class="badge bg-success">Activo</span>
                          <span v-else class="badge bg-danger">Inactivo</span>
                      </td>
                      <td>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal-default" @click="abrirModal('personas','actualizar',personas)">
                              Editar <i class="fas fa-edit"></i>
                            </button>
                            <button v-if="personas.estado==1" type="button" class="btn btn-outline-danger btn-sm" @click="desactivarPersonas(personas.id)">
                              Desactivar <i class="fas fa-times"></i> 
                            </button>
                            <button v-else type="button" class="btn btn-outline-success btn-sm" @click="activarPersonas(personas.id)">
                              Activar <i class="fas fa-check"></i>
                            </button>
                      </td>
                  </tr>
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
             <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">{{titulo_modal}}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nombres</label>
                    <div class="col-sm-10">
                     <input v-model="nombres" type="text" class="form-control" id="nombres" placeholder="Nombres">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Apellidos</label>
                    <div class="col-sm-10">
                      <input v-model="apellidos" type="text" class="form-control" id="apellidos" placeholder="Apellidos">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Tipo Documento</label>
                    <div class="col-sm-10">
                      <select v-model="tipo_documento" class="form-control" id="tipo_documento">
                      <option value="">[Seleccione Tipo...]</option>
                      <option value="D">DNI</option>
                      <option value="P">Pasaporte</option>
                      <option value="O">Otro</option>
                    </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Nro Documento</label>
                    <div class="col-sm-10">
                      <input v-model="nro_documento" type="number" class="form-control" id="nro_documento" placeholder="Nro Documento">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Direccion</label>
                    <div class="col-sm-10">
                      <input v-model="direccion" type="text" class="form-control" id="direccion" placeholder="Dirección">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Correo</label>
                    <div class="col-sm-10">
                       <input v-model="correo" type="email" class="form-control" id="correo" placeholder="Correo">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Telefono</label>
                    <div class="col-sm-10">
                      <input v-model="telefono" type="number" class="form-control" id="telefono" placeholder="Telefono">
                    </div>
                  </div>


                  
                </div> 
              </form>
              <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <button v-if="accion==1" type="button" class="btn btn-primary" data-dismiss="modal" @click="nuevaPersonas()">{{titulo_accion}}</button>
              <button v-else type="button" class="btn btn-primary" data-dismiss="modal" @click="actualizarPersonas()">{{titulo_accion}}</button>
            </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  </div>
</template>
<script>
export default {
    mounted (){
        this.listarPersonas();
    },
    data(){
        return {
            personas : [],
            nombres :'',
            apellidos :'',
            tipo_documento : '',
            nro_documento : '',
            direccion : '',
            correo : '',
            telefono : '',
            usuario: 1,
            id_persona:'',
            titulo_modal : '',
            titulo_accion:'',
            accion:''
        }
    },
    methods : {
        listarPersonas(){
            let url ='personas/listar';
            axios.get(url)
            .then(response=>{
                $(document).ready(function(){
                  
                
                $("#tablita").DataTable({
                        language: {
                            sProcessing: "Procesando...",
                            sLengthMenu: "Mostrar MENU registros",
                            sZeroRecords: "No se encontraron resultados",
                            sEmptyTable: "Ningún dato disponible en esta tabla",
                            sInfo:
                            "Mostrando registros del START al END de un total de TOTAL registros",
                            sInfoEmpty:
                            "Mostrando registros del 0 al 0 de un total de 0 registros",
                            sInfoFiltered: "(filtrado de un total de MAX registros)",
                            sInfoPostFix: "",
                            sSearch: "Buscar:",
                            sUrl: "",
                            sInfoThousands: ",",
                            sLoadingRecords: "Cargando...",
                            oPaginate: {
                            sFirst: "Primero",
                            sLast: "Último",
                            sNext: "Siguiente",
                            sPrevious: "Anterior"
                            },
                            oAria: {
                            sSortAscending:
                                ": Activar para ordenar la columna de manera ascendente",
                            sSortDescending:
                                ": Activar para ordenar la columna de manera descendente"
                            }
                        },

                       /*  stateSave: true,
                        "bDestroy": true */
                        
                        });
                });        
                this.personas = response.data;

            })
            .catch(error=>console.log(error))
        },
        nuevaPersonas(){
            let url ='personas/crear';
            axios.post(url,{
                'nombres' : this.nombres,
                'apellidos': this.apellidos,
                'tipo_documento': this.tipo_documento,
                'nro_documento': this.nro_documento,
                'direccion': this.direccion,
                'correo': this.correo,
                'telefono': this.telefono
            })
            .then(response=>{
              $("#tablita").dataTable().fnDestroy();
                this.listarPersonas();
                     
            })
            .catch(error=>console.log(error));
        },
        abrirModal(titulo, accion , data = []){
            switch(titulo){
                case 'personas':{
                    switch (accion){
                        case 'nuevo':{
                              this.titulo_modal ='Registrar Persona';
                              this.titulo_accion = 'Guardar';
                              this.accion='1'
                              this.nombres='';
                              this.apellidos='';
                              this.tipo_documento='';
                              this.nro_documento='';
                              this.direccion='';
                              this.correo='';
                              this.telefono='';  
                              break;
                        }
                        case 'actualizar':{
                              this.titulo_modal ='Actualizar Persona';
                              this.titulo_accion = 'Actualizar'; 
                              this.accion='2'
                              this.nombres= data['nombres'];
                              this.apellidos= data['apellidos'];
                              this.tipo_documento= data['tipo_documento'];
                              this.nro_documento= data['nro_documento'];
                              this.direccion= data['direccion'];
                              this.correo= data['correo'];
                              this.telefono= data['telefono'];
                              this.id_categoria = data['id'];  
                              break; 
                        }
                    }
                }
            }
        },
        actualizarPersonas(){
            
            let url ='personas/actualizar/';
            axios.put(url+this.id_categoria,{
                'nombres' : this.nombres,
                'apellidos': this.apellidos,
                'tipo_documento': this.tipo_documento,
                'nro_documento': this.nro_documento,
                'direccion': this.direccion,
                'correo': this.correo,
                'telefono': this.telefono
            })
            .then(response=>{
              $("#tablita").dataTable().fnDestroy();
              Vue.swal(
                               'Actualizado',
                               'Persona Actualizado con Exito',
                               'success'
                           )
                this.listarPersonas();           
            })
            .catch(error=>console.log(error));
             
        },
        desactivarPersonas(id){
          Vue.swal({
                    title: 'Estas seguro de desactivar esta Persona?',
                    //text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si Desactivar!'
                    }).then((result) => {
                      if (result.value) {
            let url ='personas/desactivar/';
            axios.put(url+id)
            .then(respose=>{
              $("#tablita").dataTable().fnDestroy();
                this.listarPersonas();
                Vue.swal(
                        'Desactivada',
                        'Persona Desactivada con Exito',
                        'success'
                     )
            })
            .catch(error=>console.log(error))
                }
            })
        },
        activarPersonas(id){
          Vue.swal({
                    title: 'Estas seguro de activar esta Persona?',
                    //text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si Activar!'
                    }).then((result) => {
                      if (result.value) {
            let url ='personas/activar/';
            axios.put(url+id)
            .then(respose=>{
              Vue.swal(
                        'Activado',
                        'Persona Activada con Exito',
                        'success'
                     )
                $("#tablita").dataTable().fnDestroy();     
                this.listarPersonas();
            })
            .catch(error=>console.log(error))
             }
          })
        }

    }
}
</script>

<style>

</style>