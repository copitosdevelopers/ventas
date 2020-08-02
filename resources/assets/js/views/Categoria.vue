<template>
  <div class="card mt-2" >
              <div class="card-header">
                <h3 class="card-title">Listado de Categorias 
                    </h3>
                    <button type="button" class="btn btn-outline-primary btn-sm float-right" data-toggle="modal" data-target="#modal-default" @click="abrirModal('categoria','nuevo')">
                              Nuevo <i class="fas fa-plus"></i>
                    </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nombre</th>
                      <th>Descripcion</th>
                      <th style="width: 40px">Estado</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(categoria, index) in categorias " :key="categoria.id">
                      <td>{{index+1}}</td>
                      <td>{{categoria.nombre}}</td>
                      <td>{{categoria.descripcion}}</td>                   
                      <td>
                          <span v-if="categoria.estado==1" class="badge bg-success">Activo</span>
                          <span v-else class="badge bg-danger">Inactivo</span>
                      </td>
                      <td>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal-default" @click="abrirModal('categoria','actualizar',categoria)">
                              Editar <i class="fas fa-edit"></i>
                            </button>
                            <button v-if="categoria.estado==1" type="button" class="btn btn-outline-danger btn-sm" @click="desactivarCategoria(categoria.id)">
                              Desactivar <i class="fas fa-times"></i> 
                            </button>
                            <button v-else type="button" class="btn btn-outline-success btn-sm" @click="activarCategoria(categoria.id)">
                              Activar <i class="fas fa-check"></i>
                            </button>
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
              <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{titulo_modal}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre</label>
                    <input v-model="nombre" type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingrese Nombre">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Descripcion</label>
                    <input v-model="descripcion" type="text" class="form-control" id="exampleInputPassword1" placeholder="Ingrese Descripcion">
                  </div>                 
                   
                </div>
                 
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <button v-if="accion==1" type="button" class="btn btn-primary" data-dismiss="modal" @click="nuevaCategoria()">{{titulo_accion}}</button>
              <button v-else type="button" class="btn btn-primary" data-dismiss="modal" @click="actualizarCategoria()">{{titulo_accion}}</button>
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
        this.listarCategoria();
    },
    data(){
        return {
            categorias : [],
            nombre :'',
            descripcion :'',
            usuario: 1,
            id_categoria:'',
            titulo_modal : '',
            titulo_accion:'',
            accion:'',
            errorCategoria: 0,
            errorMsjCategoria: []
        }
    }, 
    methods : {
        listarCategoria(){
            let url ='categoria/listar';
            axios.get(url)
            .then(response=>{
                this.categorias = response.data;
            })
            .catch(error=>console.log(error))
        },
        desactivarCategoria(id){
          Vue.swal({
                    title: 'Estas seguro de desactivar esta Categoria?',
                    //text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si Desactivar!'
                    }).then((result) => {
                      if (result.value) {
            let url ='categoria/desactivar/';
            axios.put(url+id)
            .then(respose=>{
                this.listarCategoria();
                Vue.swal(
                        'Desactivada',
                        'Categoria Desactivada con Exito',
                        'success'
                     )
            })
            .catch(error=>console.log(error))
                }
            })
        },
        activarCategoria(id){
          Vue.swal({
                    title: 'Estas seguro de activar esta Categoria?',
                    //text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si Activar!'
                    }).then((result) => {
                      if (result.value) {
            let url ='categoria/activar/';
            axios.put(url+id)
            .then(respose=>{
              Vue.swal(
                        'Activado',
                        'Categoria Activada con Exito',
                        'success'
                     )
                this.listarCategoria();
            })
            .catch(error=>console.log(error))
             }
          })
        },
        nuevaCategoria(){

         
          /*if(this.validarCategoria()){
            return;
             
           }*/  
            let url ='categoria/crear';
            axios.post(url,{
                'nombre' : this.nombre,
                'descripcion': this.descripcion,
                'usuario': this.usuario
            })
            .then(response=>{
                this.listarCategoria();
                this.nombre='',
                this.descripcion='' 
                this.validarCategoria();           
            })
            .catch(error=>console.log(error));
        },
        /*validarCategoria(){
          let app = this;
          this.errorCategoria=0;
          this.errorMsjCategoria = [];
          
          if(!this.nombre)
            this.errorMsjCategoria.push("El nombres es obligatorio");
            this.errorCategoria=1;
            console.log(this.errorCategoria);
          return app.errorCategoria;
        },*/
        actualizarCategoria(){
            
            let url ='categoria/actualizar/';
            axios.put(url+this.id_categoria,{
                'nombre' : this.nombre,
                'descripcion': this.descripcion,
                'usuario': this.usuario
            })
            .then(response=>{
              Vue.swal(
                               'Actualizado',
                               'Categoria Actualizado con Exito',
                               'success'
                           )
                this.listarCategoria();
                this.nombre='',
                this.descripcion=''            
            })
            .catch(error=>console.log(error));
             
        },
        abrirModal(titulo, accion , data = []){
            switch(titulo){
                case 'categoria':{
                    switch (accion){
                        case 'nuevo':{
                              this.titulo_modal ='Registrar Categoria';
                              this.titulo_accion = 'Guardar';
                              this.accion='1'
                              this.nombre='';
                              this.descripcion='';  
                              break;
                        }
                        case 'actualizar':{
                              this.titulo_modal ='Actualizar Categoria';
                              this.titulo_accion = 'Actualizar'; 
                              this.accion='2'
                              this.nombre= data['nombre'];
                              this.descripcion= data['descripcion'];
                              this.id_categoria = data['id'];  
                              break; 
                        }
                    }
                }
            }
        }


    }
}
</script>
 