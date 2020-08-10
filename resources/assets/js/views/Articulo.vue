<template>
<div class="card mt-2" >
              <div class="card-header">
                <h3 class="card-title">Listado de Articulos
                    </h3>
                    <button type="button" class="btn btn-outline-primary btn-sm float-right" data-toggle="modal" data-target="#modal-default" @click="abrirModal('articulo','nuevo')">
                              Nuevo <i class="fas fa-plus"></i>
                    </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Precio</th>
                      <th>Stock</th>
                      <th>Descripcion</th>
                      <th>Categoria</th>
                      <th style="width: 40px">Estado</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(articulo, index) in articulos " :key="articulo.id">
                      <td>{{index+1}}</td>
                      <td>{{articulo.codigo}}</td>
                      <td>{{articulo.nombre}}</td>
                      <td>{{articulo.precio}}</td>
                      <td>{{articulo.stock}}</td>
                      <td>{{articulo.descripcion}}</td>
                      <td>{{articulo.nombre_categoria}}</td> 
                                     
                      <td>
                          <span v-if="articulo.estado==1" class="badge bg-success">Activo</span>
                          <span v-else class="badge bg-danger">Inactivo</span>
                      </td>
                      <td>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal-default" @click="abrirModal('articulo','actualizar',articulo)">
                              Editar <i class="fas fa-edit"></i>
                            </button>
                            <button v-if="articulo.estado==1" type="button" class="btn btn-outline-danger btn-sm" @click="desactivarArticulo(articulo.id)">
                              Desactivar <i class="fas fa-times"></i> 
                            </button>
                            <button v-else type="button" class="btn btn-outline-success btn-sm" @click="activarArticulo(articulo.id)">
                              Activar <i class="fas fa-check"></i>
                            </button>
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
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
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Categoria</label>
                    <div class="col-sm-10">
                     <select class="form-control" v-model="id_categoria">                          
                          <option v-for="categoria in categorias" v-bind:key="categoria.id"  v-bind:value="categoria.id">
                          {{ categoria.nombre }}
                          </option>
                    </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Codigo</label>
                    <div class="col-sm-10">
                       <input v-model="codigo" type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingrese codigo">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                       <input v-model="nombre" type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingrese Nombre">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Precio</label>
                    <div class="col-sm-10">
                      <input v-model="precio" type="number" class="form-control"  placeholder="Ingrese precio">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Stock</label>
                    <div class="col-sm-10">
                      <input v-model="stock" type="number" class="form-control"  placeholder="Ingrese stock">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Descripcion</label>
                    <div class="col-sm-10">
                        <input v-model="descripcion" type="text" class="form-control" id="exampleInputPassword1" placeholder="Ingrese Descripcion">
                    </div>
                  </div>

                 


                  
                </div> 
              </form>
              <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <button v-if="accion==1" type="button" class="btn btn-primary" data-dismiss="modal" @click="nuevoArticulo()">{{titulo_accion}}</button>
              <button v-else type="button" class="btn btn-primary" data-dismiss="modal" @click="actualizarArticulo()">{{titulo_accion}}</button>
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
        this.listarArticulo();
        this.listarCategoria();
    },
    data(){
        return {
            articulos : [],
            codigo:'',
            id_categoria: '',
            precio:'',
            stock:'',
            nombre :'',
            descripcion :'',
            id_articulo:'',
            titulo_modal : '',
            titulo_accion:'',
            accion:'',
            categorias:[]
        }
    }, 
    methods : {
        listarArticulo(){
            let url ='articulo/listar';
            axios.get(url)
            .then(response=>{
                this.articulos = response.data;
            })
            .catch(error=>console.log(error))
        },
        listarCategoria(){
            let url ='categoria/listar';
            axios.get(url)
            .then(response=>{
                this.categorias = response.data;
            })
            .catch(error=>console.log(error))
        },
        desactivarArticulo(id){
            let url ='articulo/desactivar/';
            axios.put(url+id)
            .then(respose=>{
                this.listarArticulo();
            })
            .catch(error=>console.log(error))
        },
        activarArticulo(id){
            let url ='articulo/activar/';
            axios.put(url+id)
            .then(respose=>{
                this.listarArticulo();
            })
            .catch(error=>console.log(error))
        },
        nuevoArticulo(){
            let url ='articulo/crear';
            axios.post(url,{
                'nombre' : this.nombre,
                'descripcion': this.descripcion,
                'codigo': this.codigo,
                'stock': this.stock,
                'precio': this.precio,
                'id_categoria': this.id_categoria
                
            })
            .then(response=>{
                this.listarArticulo();
                this.nombre='',
                this.descripcion=''  
                this.stock='',
                this.precio=''  
                this.codigo=''  
                this.id_categoria=''
                           
            })
            .catch(error=>console.log(error));
        },
        actualizarArticulo(){
            let url ='articulo/actualizar/';
            axios.put(url+this.id_articulo,{
                'nombre' : this.nombre,
                'descripcion': this.descripcion,
                'codigo': this.codigo,
                'stock': this.stock,
                'precio': this.precio,
                'id_categoria': this.id_categoria
               
            })
            .then(response=>{
                this.listarArticulo();
                this.nombre='',
                this.descripcion=''  
                this.stock='',
                this.precio=''  
                this.codigo=''  
                this.id_categoria=''           
            })
            .catch(error=>console.log(error));
        },
        abrirModal(titulo, accion , data = []){
            switch(titulo){
                case 'articulo':{
                    switch (accion){
                        case 'nuevo':{
                              this.titulo_modal ='Registrar Articulo';
                              this.titulo_accion = 'Guardar';
                              this.accion='1'
                              this.nombre='';
                              this.descripcion=''; 
                              this.precio='';
                              this.stock='';
                              this.codigo=''; 
                              this.id_categoria='';  
                              break;
                        }
                        case 'actualizar':{
                              this.titulo_modal ='Actualizar Articulo';
                              this.titulo_accion = 'Actualizar'; 
                              this.accion='2'
                              this.nombre= data['nombre'];
                              this.descripcion= data['descripcion'];
                              this.stock= data['stock'];
                              this.precio= data['precio'];
                              this.codigo= data['codigo'];
                              this.id_categoria= data['id_categoria'];                            
                              this.id_articulo = data['id'];  
                              break; 
                        }
                    }
                }
            }
        }


    }
}
</script>