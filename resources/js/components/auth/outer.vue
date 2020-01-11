<template>
  <div>
    <div class="d-flex" id="wrapper">
      <!-- Sidebar -->
      <div class="bg-dark border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">
          <div class="row px-2 no-gutters">
            <div class="col-8 mt-2 ml-3">
              <h5 class="text-white">Neo RestoBar</h5>
            </div>
            <div class="col-3 mt-1">
              <i class="fas fa-utensils fa-2x" style="color:white"></i>
            </div>
          </div>
        </div>
        <div class="list-group list-group-flush">
          <!--  <div class="bg-primary text-center"><h5>Navegacion</h5></div> -->
          <a
            data-toggle="collapse"
            href="#collapseExample"
            class="list-group-item list-group-item-action bg-dark"
          >Home</a>
          <div class="collapse" id="collapseExample">
            <a href="#" class="list-group-item list-group-item-action list-group-item-light">1</a>
            <a href="#" class="list-group-item list-group-item-action list-group-item-light">2</a>
            <a href="#" class="list-group-item list-group-item-action list-group-item-light">3</a>
          </div>
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
          <button class="btn btn-primary rounded-circle border-0" id="menu-toggle" @click="toggle()">
            <i class="fa "></i>
          </button>

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