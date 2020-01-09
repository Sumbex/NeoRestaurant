<template>
  <div>
    <div class="d-flex" id="wrapper">
      <!-- Sidebar -->
      <div class="bg-dark border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">Neo RestoBar</div>
        <div class="list-group list-group-flush">
          <a href="#" class="list-group-item list-group-item-action bg-dark">Home</a>
          <a href="#" class="list-group-item list-group-item-action bg-dark">Sucursales</a>
          <a href="#" class="list-group-item list-group-item-action bg-dark">Usuarios</a>
          <a href="#" class="list-group-item list-group-item-action bg-dark">Almacen</a>
          <a href="#" class="list-group-item list-group-item-action bg-dark">Compras</a>
          <a href="#" class="list-group-item list-group-item-action bg-dark">Productos</a>
          <a href="#" class="list-group-item list-group-item-action bg-dark">Ventas</a>
          <a href="#" class="list-group-item list-group-item-action bg-dark">Cajas</a>
        </div>
      </div>
      <!-- /#sidebar-wrapper -->

      <!-- Page Content -->
      <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
          <button class="btn btn-primary" id="menu-toggle" @click="toggle()"><span class="navbar-toggler-icon"></span></button>

          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
              <li class="nav-item active">
                <a class="nav-link" href="#">
                  Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
              </li>
            </ul>-->
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="http://example.com"
                  id="dropdown07"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >Bryan Montecino</a>
                <div class="dropdown-menu" aria-labelledby="dropdown07">
                  <a class="dropdown-item" href="#" @click="logout">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </nav>

        <div class="container-fluid">
          <transition name>
            <router-view></router-view>
          </transition>
        </div>
      </div>
      <!-- /#page-content-wrapper -->
    </div>
  </div>
</template>

<script src="./outer.js"></script>
<style src="./outer.css"></style>