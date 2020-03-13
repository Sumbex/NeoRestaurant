<template>
  <div class="container">
    <div class="row justify-center my-3">
      <div class="col-sm-12 text-center">
        <h2>Seleccione una Sucursal</h2>
      </div>
      <div class="col-sm-4 my-1" v-for="sucursal in sucursales" prop="sucursal" :key="sucursal.id">
        <div class="card text-white bg-info mb-3">
          <a
            @click="url({
               id: sucursal.id
          })"
            class="text-white"
            style="text-decoration:none"
          >
            <div class="card-body">
              <h5 class="card-title text-center">
                <i class="fas fa-store-alt fa-3x"></i>
              </h5>
              <h4 class="card-text text-center">{{sucursal.sucursal}}</h4>
              <p class="card-text text-center">{{sucursal.direccion}}</p>
            </div>
          </a>
          <div class="card-footer text-center">
            <button type="button" class="btn btn-success">Abierto/Cerrado</button>
          </div>
        </div>
      </div>
    </div>

    <!-- <div class="row justify-center my-5" v-show="!tabla">
      <div class="loader"></div>
    </div>

    <div class="row justify-center my-3" v-show="tabla">
      <div class="card col-md-12">
        <div class="row justify-center">
          <div class="col-md-12 my-1">
            <h3 class="text-center">Sucursales</h3>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table">
                <thead class="thead-dark text-center">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Sucursal</th>
                    <th scope="col">Direccion</th>
                    <th scope="col">Observacion</th>
                    <th scope="col">Creada por:</th>
                    <th scope="col">Creada:</th>
                    <th scope="col">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="sucursal in sucursales" :prop="sucursal" :key="sucursal.id">
                    <th scope="row">{{sucursal.id}}</th>
                    <td>{{sucursal.sucursal}}</td>
                    <td>{{sucursal.direccion}}</td>
                    <td>{{sucursal.observacion}}</td>
                    <td>{{sucursal.nombre}}</td>
                    <td>{{sucursal.created_at}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>-->
  </div>
</template>

<style src="./cocina.css"></style>
<script src="./cocina.js"></script>
