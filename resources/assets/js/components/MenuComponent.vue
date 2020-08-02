<template>
  <nav class="mt-2">
    <ul
      class="nav nav-pills nav-sidebar flex-column"
      data-widget="treeview"
      role="menu"
      data-accordion="false"
    >
      <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
      <li class="nav-item ">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Almacen
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <router-link :to="{name:'administrarCategoria'}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Categoria</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{name:'administrarPersonas'}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Personas</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{name:'administrarArticulos'}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Articulos</p>
            </router-link>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Inactive Page</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Simple Link
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {};
</script>

<style></style>
