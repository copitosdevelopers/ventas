<template>
<!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Personas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Almacen</a></li>
              <li class="breadcrumb-item active">Personas</li>
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
              <div class="card-header">
                <h3 class="card-title">Listado de Personas</h3>
              </div>
              <!-- /.card-header -->
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
                  <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Apellidos y Nombres</th>
                    <th>Documento</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                  </tr>
                  </tfoot>
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
        }

    }
}
</script>

<style>

</style>