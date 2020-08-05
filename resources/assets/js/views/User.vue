<template>
  <div class="card mt-2" >
              <div class="card-header">
                <h3 class="card-title">Lista de Usuarios 
                    </h3>
                    <button type="button" class="btn btn-outline-primary btn-sm float-right" data-toggle="modal" data-target="#modal-lg" @click="abrirModal('usuario','nuevo')">
                              Nuevo <i class="fas fa-plus"></i>
                    </button>
              </div>
              <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Buscar">

              <div class="input-group-append">
                <button type="" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>
                </button>
              </div>
            </div>
              
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nombre</th>
                      <th>Direccion </th>
                      <th>T. Doc</th>
                      <th>Email </th>
                      <th>Usuario</th>
                      <th>Rol</th> 
                      <th style="width: 40px">Estado</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(usuario, index) in usuariosArray " :key="usuario.id">
                      <td>{{index+1}}</td>
                      <td>{{usuario.nombres}}</td>
                      <td>{{usuario.direccion}}</td>
                      <td>{{usuario.tipo_documento}}</td>       
                      <td>{{usuario.correo}}</td>  
                      <td>{{usuario.usuario}}</td>      
                       <td>{{usuario.rol}}</td>
                      <td>
                          <span v-if="usuario.estado==1" class="badge bg-success">Activo</span>
                          <span v-else class="badge bg-danger">Inactivo</span>
                      </td>
                      <td>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal-lg" @click="abrirModal('usuario','actualizar',usuario)">
                              Editar <i class="fas fa-edit"></i>
                            </button>
                            <button v-if="usuario.estado==1" type="button" class="btn btn-outline-danger btn-sm" @click="desactivarUsuario(usuario.id)">
                              Desactivar  <i class="fas fa-times"></i> 
                            </button>
                            <button v-else type="button" class="btn btn-outline-success btn-sm" @click="activarUsuario(usuario.id)">
                              Activar <i class="fas fa-check"></i>
                            </button>
                      </td>
                    </tr>
                  
                    
                  </tbody>
                </table>
              </div>
      <div class="modal fade" id="modal-lg">
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
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                      <input v-model="nombres" type="text" class="form-control" id="inputEmail3" placeholder="Nombre">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Apellidos</label>
                    <div class="col-sm-10">
                      <input v-model="apellidos" type="text" class="form-control" id="inputPassword3" placeholder="Apellidos">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">T. Documento</label>
                    <div class="col-sm-10">
                      <!--<input v-model="tipo_documento" type="text" class="form-control" id="inputPassword3" placeholder="Apellidos">-->
                      <select name="" id="" v-model="tipo_documento" class="form-control">
                        <option value="">Seleccionar</option>
                        <option value="D">Dni</option>
                        <option value="P">Pasaporte</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Nro. Documento</label>
                    <div class="col-sm-10">
                      <input v-model="nro_documento" type="number" class="form-control" id="inputPassword3" placeholder="Documento">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Direccion</label>
                    <div class="col-sm-10">
                      <input v-model="direccion" type="text" class="form-control" id="inputPassword3" placeholder="direccion">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input v-model="correo" type="text" class="form-control" id="inputPassword3" placeholder="Email">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Rol</label>
                    <div class="col-sm-10">
                      <select name="" id="" class="form-control" v-model="idrol">
                          <option value="0">Seleccione un Rol</option>p    
                          <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id">{{rol.nombre}}</option>
                     </select>
                    </div>
                  
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Telefono</label>
                    <div class="col-sm-10">
                      <input v-model="telefono" type="number" class="form-control" id="inputPassword3" placeholder="Telefono">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Usuario</label>
                    <div class="col-sm-10">
                      <input v-model="usuario" type="text" class="form-control" id="inputPassword3" placeholder="Telefono">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <input v-model="password" required type="password" class="form-control" id="inputPassword3" placeholder="password">
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
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
   </div>
</template>

<script>
export default {
    mounted (){
        this.listarUsuarios();
        this.listarRoles();
    },
    data(){
        return {
            idrol:'',
            usuario: '',
            password :'',
            id_usuario:'',
            usuariosArray : [],
            arrayRol :[],  
            nombres :'',
            apellidos :'',
            tipo_documento: 1,
            nro_documento:'',
            direccion:'',
            correo:'',
            telefono:'',
            titulo_modal : '',
            titulo_accion:'',
            accion:'',
            errorCategoria: 0,
            errorMsjCategoria: []
        }
    }, 
    methods : {
        listarUsuarios(){
            let url ='usuario/listar';
            axios.get(url)
            .then(response=>{
                this.usuariosArray = response.data;
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
        nuevoUsuario(){
            let url ='usuario/registrar';
            axios.post(url,{
            'nombres' : this.nombres,
            'apellidos' : this.apellidos,
            'tipo_documento':  this.tipo_documento,
            'nro_documento': this.nro_documento,
            'direccion': this.direccion,
            'correo': this.correo,
            'telefono': this.telefono,
            'contacto: this':this.contacto,
            'telefono_contacto': this.telefono_contacto,
            'usuario': this.usuario,
            'password': this.password,
            'idrol': this.idrol
            })
            .then(response=>{
                this.listarUsuarios();         
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
                case 'usuario':{
                    switch (accion){
                        case 'nuevo':{
                              this.id_usuario='',
                              this.titulo_modal ='Registrar Usuario';
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
                        case 'actualizar':{
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
 