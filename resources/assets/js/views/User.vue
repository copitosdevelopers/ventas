<template>
  <div class="card mt-2">
    <div class="card-header">
      <h3 class="card-title">Lista de Usuarios</h3>
      <button
        type="button"
        class="btn btn-outline-primary btn-sm float-right"
        data-toggle="modal"
        data-target="#modal-usuario"
        @click="abrirModal('crear', '')"
      >
        Nuevo <i class="fas fa-plus"></i>
      </button>
    </div>
    <div class="input-group">
      <input
        type="text"
        name="search"
        class="form-control"
        placeholder="Buscar"
      />

      <div class="input-group-append">
        <button type="" name="submit" class="btn btn-warning">
          <i class="fas fa-search"></i>
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
            <th>Direccion</th>
            <th>T. Doc</th>
            <th>Email</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th style="width: 40px">Estado</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(usuario, index) in usuariosArray" :key="usuario.id">
            <td>{{ index + 1 }}</td>
            <td>{{ usuario.nombres }}</td>
            <td>{{ usuario.direccion }}</td>
            <td>{{ usuario.tipo_documento }}</td>
            <td>{{ usuario.correo }}</td>
            <td>{{ usuario.usuario }}</td>
            <td>{{ usuario.rol }}</td>
            <td>
              <span v-if="usuario.estado == 1" class="badge bg-success"
                >Activo</span
              >
              <span v-else class="badge bg-danger">Inactivo</span>
            </td>
            <td>
              <button
                type="button"
                class="btn btn-outline-primary btn-sm"
                data-toggle="modal"
                data-target="#modal-usuario"
                @click="abrirModal('editar', usuario)"
              >
                Editar <i class="fas fa-edit"></i>
              </button>
              <button
                v-if="usuario.estado == 1"
                type="button"
                class="btn btn-outline-danger btn-sm"
                @click="desactivarUsuario(usuario.id)"
              >
                Desactivar <i class="fas fa-times"></i>
              </button>
              <button
                v-else
                type="button"
                class="btn btn-outline-success btn-sm"
                @click="activarUsuario(usuario.id)"
              >
                Activar <i class="fas fa-check"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="modal fade" id="modal-usuario">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">{{titulo_modal}}</h3>
            </div>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <div class="card-body">
                <div class="form-group row">
                  <label   class="col-sm-2 col-form-label">Persona</label>
                  <div class="col-sm-10">
                   <select id="personas" class="form-control select2" style="width: 100%;">
                        <option selected disabled>Buscar y seleccionar persona</option>
                            <option v-for="persona in personas" 
                              :key="persona.id" 
                              :value="persona.id" 
                              >
                              {{persona.nombre_completo}}
                        </option>
                    </select>
                    <!-- <input type="text" id="id_persona" class="form-control" v-model="idPersona"> -->
                  </div>

                </div>
                <div class="form-group row">
                  <label   class="col-sm-2 col-form-label"
                    >Usuario</label
                  >
                  <div class="col-sm-10">
                    <input
                      v-model="dataUsuario.usuario"
                      type="text"
                      class="form-control"
                      placeholder="usuario"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label   class="col-sm-2 col-form-label"
                    >Password</label
                  >
                  <div class="col-sm-10">
                    <input
                      v-model="dataUsuario.password"
                      type="text"
                      class="form-control"
                       
                      placeholder="password"
                    />
                  </div>
                </div>

                 <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Rol</label>
                    <div class="col-sm-10">
                      <select name="" class="form-control" v-model="dataUsuario.idrol">
                          <option value="0">Seleccione un Rol</option>p    
                          <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id">{{rol.nombre}}</option>
                     </select>
                    </div>
                  
                  </div>  
                 
              </div>
            </form>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <button v-if="modoEdit" type="button" class="btn btn-primary" data-dismiss="modal" @click="actualizarUsuario(dataUsuario.id)">Actualizar</button>
              <button v-else type="button" class="btn btn-primary" data-dismiss="modal" @click="crearUsuario()">Registrar</button>
            </div>
           
          </div>

        </div>
         
      </div>
      <!-- /.modal-dialog -->
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.obtenerPersonas();
    this.listarUsuarios();
    this.listarRoles();
  },
  data() {
    return {
      usuariosArray: [],
      arrayRol: [],
      titulo_modal: "",
      personas: [],
      modoEdit: false,
      dataUsuario: {},
      idPersona: null
    };
  },
  methods: {
    obtenerPersonas() {
      let app = this;
      let url = "personas/obtenerPersonas";
      axios
        .get(url)
        .then((response) => {
          app.personas = response.data;
        })
        .catch((error) => console.log(error));
    },

    listarUsuarios() {
      let url = "usuario/listar";
      axios
        .get(url)
        .then((response) => {
          this.usuariosArray = response.data;
        })
        .catch((error) => console.log(error));
    },

    desactivarUsuario(id) {
      Vue.swal({
        title: "Estas seguro de desactivar este Usuario?",
        //text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si Desactivar!",
      }).then((result) => {
        if (result.value) {
          let url = "usuario/desactivar/";
          axios
            .put(url + id)
            .then((respose) => {
              this.listarUsuarios();
              Vue.swal(
                "Desactivado",
                "Usuario Desactivado con Exito",
                "success"
              );
            })
            .catch((error) => console.log(error));
        }
      });
    },
    activarUsuario(id) {
      Vue.swal({
        title: "Estas seguro de activar este Usuario?",
        //text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si Activar!",
      }).then((result) => {
        if (result.value) {
          let url = "usuario/activar/";
          axios
            .put(url + id)
            .then((respose) => {
              Vue.swal("Activado", "Usuario Activado con Exito", "success");
              this.listarUsuarios();
            })
            .catch((error) => console.log(error));
        }
      });
    },

    listarRoles() {
      let url = "rol/listar";
      axios
        .get(url)
        .then((response) => {
          this.arrayRol = response.data;
        })
        .catch((erros) => console.log(error));
    },

    crearUsuario() {
      let app = this;
      let url = "usuario/registrar";
      app.dataUsuario.id = app.idPersona;
      let nuevoUsuario = app.dataUsuario;
      console.log(nuevoUsuario);
      axios.post(url, nuevoUsuario)
        .then((response) => {
          Vue.swal('usuario registrado');
          this.listarUsuarios();
        })
        .catch((error) => console.log(error));
    },

    actualizarUsuario(id) {
      let url = "usuario/actualizar/"+id;
      let editarUsuario = this.dataUsuario;
      axios.put(url, editarUsuario)
        .then((response) => {
          Vue.swal("usuario actualiado");
          this.listarUsuarios();
        })
        .catch((error) => console.log(error));
    },

    abrirModal(accion, data=[]) {
      var app = this;
     $(document).ready(function() {
       
        $(".select2").select2()

        $('#personas').on('select2:select', function (e) {
            app.idPersona = e.params.data.id;
            console.log(app.idPersona);
        }); 
      }); 

      if(accion == 'crear'){

        let app = this;
        app.modoEdit = false;
        app.titulo_modal = 'Registrando usuario';
        app.dataUsuario = {};

      }else{

        let app = this;
        app.modoEdit = true;
        app.titulo_modal = 'Actualizar usuario';
        app.dataUsuario = data;

      }
        

    },
  },
};
</script>
