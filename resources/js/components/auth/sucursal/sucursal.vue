<template>
  <div class="container">
    <div class="row justify-center my-3">
      <div class="card col-md-12">
        <div class="form-row justify-center">
          <div class="col-12 my-1">
            <h3 class="text-center">Formulario</h3>
          </div>
          <div class="input-group my-1">
            <div class="form-group col-md-6">
              <input
                type="text"
                v-model="sucursal"
                class="form-control"
                placeholder="Nombre Sucursal"
                aria-label="Nombre"
              />
            </div>
            <div class="form-group col-md-6">
              <input
                type="text"
                v-model="direccion"
                class="form-control"
                placeholder="Direccion"
                aria-label="Direccion"
              />
            </div>
            <div class="form-group col-md-12">
              <textarea
                class="form-control resize-none"
                v-model="observacion"
                placeholder="Observacion"
                aria-label="Observacion"
              ></textarea>
            </div>
            <div class="form-group col-md-12 mt-2 mb-3 text-center">
              <button
                type="button"
                :disabled="!!guardar"
                v-on:click="guardar = !guardar"
                class="btn btn-success rounded-pill"
                @click="ingresar()"
              >
                <span v-show="!guardar">Guardar</span>
                <span v-show="guardar">
                  Guardando Sucursal
                  <i class="fa fa-circle-o-notch fa-spin"></i>
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-center my-5" v-show="!tabla">
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
                <thead class="thead-dark">
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
    </div>

    <vue-snotify></vue-snotify>
  </div>
</template>

<style src="./sucursal.css"></style>
<script src="./sucursal.js"></script>
