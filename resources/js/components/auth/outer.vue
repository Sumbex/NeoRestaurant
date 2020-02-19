<template>
  <div class="d-flex bg-light" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark border-right" id="sidebar-wrapper">
      <div class="sidebar-heading border-bottom">
        <a @click="url('Home')" style="text-decoration:none">
          <div class="row px-2 no-gutters">
            <div class="col-8 mt-2 ml-3">
              <h5 class="text-white">Neo RestoBar</h5>
            </div>
            <div class="col-3 mt-1">
              <i class="fas fa-utensils fa-2x" style="color:white"></i>
            </div>
          </div>
        </a>
      </div>
      <div class="list-group list-group-flush">
        <span class="list-group-item bg-info text-white bg-primary text-center">
          <h6>Navegacion</h6>
        </span>
        <a @click="url('POS')" class="list-group-item list-group-item-action bg-dark text-white">POS</a>
        <a
          data-toggle="collapse"
          href="#collapseSucursal"
          class="list-group-item list-group-item-action bg-dark text-white"
        >
          Sucursal
          <i class="fa float-right"></i>
        </a>
        <div class="collapse" id="collapseSucursal">
          <a
            class="list-group-item list-group-item-action list-group-item-light"
            :class="[currentPage.includes('sucursales') ? activeClass : 'list-group-item-action']"
            @click="url('Sucursal')"
          >Sucursales</a>
          <a
            class="list-group-item list-group-item-action list-group-item-light"
            :class="[currentPage.includes('mesas') ? activeClass : 'list-group-item-action']"
            @click="url('Mesas')"
          >Mesas</a>
        </div>
        <a
          data-toggle="collapse"
          href="#collapseAlmacen"
          class="list-group-item list-group-item-action bg-dark text-white"
        >
          Almacen
          <i class="fa float-right"></i>
        </a>
        <div class="collapse" id="collapseAlmacen">
          <a
            class="list-group-item list-group-item-action list-group-item-light"
            :class="[currentPage.includes('provedores') ? activeClass : 'list-group-item-action']"
            @click="url('Provedores')"
          >Provedores</a>
          <a
            class="list-group-item list-group-item-action list-group-item-light"
            :class="[currentPage.includes('insumos') ? activeClass : 'list-group-item-action']"
            @click="url('Insumos')"
          >Insumos</a>
          <a
            class="list-group-item list-group-item-action list-group-item-light"
            :class="[currentPage.includes('registro-compra') ? activeClass : 'list-group-item-action']"
            @click="url('RegistroInsumo')"
          >Registro Compras "Stock"</a>
          <a
            class="list-group-item list-group-item-action list-group-item-light"
            :class="[currentPage.includes('ver-compras') ? activeClass : 'list-group-item-action']"
            @click="url('VerCompraInsumos')"
          >Ver Compras</a>
        </div>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Productos</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Ventas</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Cajas</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Configuracion</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
        <button class="btn btn-primary rounded-circle border-0" id="menu-toggle" @click="toggle()">
          <i class="fa"></i>
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
                class="nav-link dropdown-toggle text-white"
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
      <vue-snotify></vue-snotify>
    </div>
    <!-- /#page-content-wrapper -->
  </div>
</template>



<script src="./outer.js"></script>
<style src="./outer.css"></style>