<template>
  <div class="card mt-2" >
              <div class="card-header">
                <h3 class="card-title">Listado de Roles 
                    </h3>
                    <button type="button" class="btn btn-outline-primary btn-sm float-right" data-toggle="modal" data-target="#modal-default" @click="abrirModal('crear', '')">
                            <i class="fas fa-plus"></i> Nuevo
                    </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nombre</th>
                      <th>Slug</th>
                      <th>Descripción</th>
                      <th style="width: 40px">Estado</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(rol, index) in rols" :key="rol.id">
                      <td>{{index+1}}</td>
                      <td>{{rol.nombre}}</td>
                      <td>{{rol.slug}}</td>   
                      <td>{{rol.descripcion}}</td>                  
                      <td>
                          <span v-if="rol.estado == '1'" class="badge bg-success">Activo &nbsp;&nbsp;</span>
                          <span v-else class="badge bg-danger">Inactivo</span>
                      </td>
                      <td>
                          <div class="btn-group">
                              <button class="btn btn-secondary" data-toggle="modal" data-target="#modal-default" @click="abrirModal('actualizar', rol)">
                                  <i class="fa fa-edit"></i> 
                                  Editar
                              </button>
                              <button :class="rol.estado == '1' ? 'btn-danger' : 'btn-success'" class="btn" @click="cambiarEstadoRol(rol.id, rol.estado)">
                                  <i :class="rol.estado == '1' ? 'fa-times' : 'fa-check'" class="fa"></i> 
                                  <span v-if="rol.estado == '1'">Desactivar</span>
                                  <span v-else>Activar</span>
                              </button>
                          </div>
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
              <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">{{tituloModal}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <form>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input v-model="dataRol.nombre" type="text" class="form-control"  placeholder="Ingresar el nombre">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Descripcion</label>
                                <input v-model="dataRol.descripcion" type="text" class="form-control" placeholder="Ingresar descripción">
                            </div> 
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button v-if="modoEdit" type="button" class="btn btn-primary" data-dismiss="modal" @click="actualizarRol(dataRol.id)">Actualizar</button>
                            <button v-else type="button" class="btn btn-primary" data-dismiss="modal" @click="crearRol()">Guardar</button>
                        </div>
                    </form>
                    <!-- <pre>
                        {{dataRol}}
                    </pre> -->
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
        let app = this;
        app.listarRols();
    },
    data(){
        return {
            rols:[],
            dataRol:{},
            modoEdit: false,
            tituloModal: ''
        }
    }, 
    methods : {
        listarRols(){
            let app = this;
            let url ='rol/listar';
            axios.get(url)
            .then(response => {
                app.rols = response.data;
                console.log(app.rols);
            })
            .catch(error => console.log(error))
        },

        abrirModal(tipo, data=[]){
            let app = this;

            if(tipo == 'crear'){

                app.modoEdit = false;
                app.tituloModal = 'Registrando rol';
                console.log(app.dataRol);

            }else{

                app.modoEdit = true;
                app.tituloModal = 'Actualizando rol';
                app.dataRol = data;
                console.log(app.dataRol);
            }

        },

        crearRol(){
            let app = this;
            let url ='rol/crear';

            let nuevoRol = app.dataRol;

            axios.post(url, nuevoRol)
            .then(response => {
                Vue.swal("Rol creado");
                app.listarRols();
            })
            .catch(error => console.log(error))
        },

        actualizarRol(id){
            let app = this;
            let url ='rol/actualizar/'+id;

            let editarRol = app.dataRol;

            axios.put(url, editarRol)
            .then(response => {
                Vue.swal("Rol actulizado");
                app.listarRols();
            })
            .catch(error => console.log(error))
        },

        cambiarEstadoRol(id, estado){
            let app = this;
            let url ='rol/cambiarEstadoRol/'+id;

            if(estado == '1'){

                Vue.swal({
                html: '<h5>¿Estas seguro de desactivar este rol?</h5>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si Desactivar!'
                    }).then((result) => {
                    if (result.value) {

                        axios.put(url)
                        .then(response => {
                            Vue.swal({
                                position: 'top-end',
                                icon: 'success',
                                html: '<h6>Rol desactivado</h6>',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            app.listarRols();
                        })
                        .catch(error => console.log(error)) 
                    
                    }
                })

            }else{

                Vue.swal({
                 html: '<h5>¿Estas seguro de activar este rol?</h5>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si Activar!'
                    }).then((result) => {
                    if (result.value) {

                        axios.put(url)
                        .then(response => {
                            Vue.swal({
                            position: 'top-end',
                            icon: 'success',
                            html: '<h6>Rol activado</h6>',
                            showConfirmButton: false,
                            timer: 1500
                            })
                            app.listarRols();
                        })
                        .catch(error => console.log(error)) 
                    
                    }
                })

            }
            
        }
    }
}
</script>
 