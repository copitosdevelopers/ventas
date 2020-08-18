<template>
  <div class="card mt-2">
    <div class="card-header">
      <h3 class="card-title">Lista de Usuarios</h3>
      <button
        type="button"
        class="btn btn-outline-primary btn-sm float-right"
        data-toggle="modal"
        data-target="#modal-lg"
        @click="abrirModal('usuario', 'nuevo')"
      >
        Nuevo <i class="fas fa-plus"></i>
      </button>
    </div>
    <!--<div class="input-group">
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
    </div>-->

    <!-- /.card-header -->
    <div class="card-body p-0">
      <table class="table table-sm">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Apellidos y Nombres</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Usuario</th>
            <th>Direccion</th>
            <th style="width: 40px">Estado</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(usuario, index) in usuariosArray" :key="usuario.id">
            <td>{{ index + 1 }}</td>
            <td>{{ usuario.apellidos }} {{ usuario.nombres }}</td>
            <td>{{ usuario.correo }}</td>
            <td>{{ usuario.rol }}</td>
            <td>{{ usuario.usuario }}</td>
            <td>{{ usuario.direccion }}</td>
            <td><span v-if="usuario.estado == 1" class="badge bg-success">Activo</span>
                <span v-else class="badge bg-danger">Inactivo</span>
            </td>
            <td>
              <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal-lg" @click="abrirModal('usuario', 'actualizar', usuario)">
                Editar <i class="fas fa-edit"></i>
              </button>
              <button v-if="usuario.estado == 1" type="button" class="btn btn-outline-danger btn-sm" @click="desactivarUsuario(usuario.id)">
                Desactivar <i class="fas fa-times"></i>
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
              <h3 class="card-title">{{ titulo_modal }}</h3>
            </div>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <div class="card-body">
                <div class="form-group row">
                  <label   class="col-sm-2 col-form-label">Nombre</label>
                  <div class="col-sm-10">
                    <select id="person" class="form-control select2" style="width: 100%;">
                      <option selected disabled value="">Buscar y seleccionar persona</option>
                      <option v-for="persona in personas" :key="persona.id" :value="persona.id">{{persona.nombre_completo}}</option>
                    </select>
                    <input type="hidden" id="valorPersona">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Usuario</label>
                  <div class="col-sm-10">
                    <input v-model="usuario" type="text" class="form-control" placeholder="usuario" />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input v-model="password" type="password" class="form-control" placeholder="password" />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-2 col-form-label">Rol</label>
                  <div class="col-sm-10">
                    <select name="" class="form-control" v-model="idrol">
                      <option value="">Seleccione un Rol</option>   
                      <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id">{{rol.nombre}}</option>
                    </select>
                  </div>
                </div> 
              </div>
            </form>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <button v-if="accion==1" type="button" class="btn btn-primary" data-dismiss="modal" @click="nuevoUsuario()">{{titulo_accion}}</button>
              <button v-else type="button" class="btn btn-primary" data-dismiss="modal" @click="actualizarUsuario()">{{titulo_accion}}</button>
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

    $(document).ready(function() {
        $(".select2").select2();

        $('#person').on('select2:select', function (e) {
            var data = e.params.data;
            $('#valorPersona').val(data.id);
            console.log($('#valorPersona').val());
        });

      });

  },
  data() {
    return {
      idrol: "",
      usuario: "",
      password: "",
      id_usuario: "",
      usuariosArray: [],
      arrayPersona: [],
      arrayRol: [],
      titulo_modal: "",
      titulo_accion: "",
      accion: "",
      personas: [],
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
    nuevoUsuario() {
      let url = "usuario/registrar";
      axios
        .post(url, {
          usuario: this.usuario,
          password: this.password,
          idrol: this.idrol,
          id: $('#valorPersona').val()
        })
        .then((response) => {
          this.listarUsuarios();
        })
        .catch((error) => console.log(error));
    },
    actualizarUsuario() {
      let url = "usuario/actualizar/";
      axios
        .put(url + $('#valorPersona').val(), {                  
          usuario: this.usuario,
          password: this.password,
          idrol: this.idrol,
          id: $('#valorPersona').val()
        })
        .then((response) => {
          Vue.swal("Actualizado", "Usuario Actualizado con Exito", "success");
          this.listarUsuarios();
        })
        .catch((error) => console.log(error));
    },
    abrirModal(titulo, accion, data = []) {
      switch (titulo) {
        case "usuario": {
          switch (accion) {
            case "nuevo": {            
              this.titulo_modal = "Registrar Usuario";
              this.titulo_accion = "Guardar";
              this.accion = "1";              
              this.usuario = "";
              this.password = "";
              $('#valorPersona').val("");
              this.idrol = ""; 
              $('#person').val('').trigger('change.select2');
              $('#person').select2({
                disabled: false
              });
              break;
            }
            case "actualizar": {
              this.titulo_modal = "Actualizar Usuario";
              this.titulo_accion = "Actualizar";
              this.accion = "2";
              this.idrol = data["idrol"];
              this.usuario = data["usuario"];
              this.password = data["password"];
              $('#person').val(data["id"]).trigger('change.select2');
              $('#valorPersona').val(data["id"]);
              $('#person').select2({
                disabled: true
              });
              //console.log(data["id"]);
              break;
            }
          }
        }
      }
    },
  },
};
</script>