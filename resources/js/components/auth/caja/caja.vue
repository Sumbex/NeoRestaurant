<template>
  <div class="container">
    <div class="row my-3">
      <div class="col-md-12">
        <div class="card">
          <div class="container-fluid">
            <h3 class="text-center">Formulario</h3>
            <div class="row justify-center">
              <div class="col-lg-6 text-center">
                <div class="form-group">
                  <select class="form-control" v-model="sucursal">
                    <option value="0">Seleccione la Sucursal</option>
                    <option
                      v-for="option in sucursal_select"
                      v-bind:value="option.id"
                      :key="option.id"
                    >{{option.descripcion}}</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-6 text-center mb-3">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Nombre de la Caja"
                    aria-label="Nombre"
                    aria-describedby="nombre-label"
                    v-model.number="nombre"
                  />
                </div>
              </div>
              <div class="form-group col-md-12 mb-3 text-center">
                <button
                  type="button"
                  class="btn btn-success rounded-pill"
                  @click="ingresarCaja()"
                >Guardar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row my-3">
      <div class="col-md-12">
        <div class="card mb-3">
          <div class="container-fluid">
            <h3 class="text-center">Cajas</h3>

            <div class="table-responsive">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Caja</th>
                    <th scope="col">Creada por:</th>
                    <th scope="col">Creada</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="caja in cajas" :prop="caja" :key="caja.id">
                    <th scope="row">{{caja.id}}</th>
                    <td>{{caja.caja}}</td>
                    <td>{{caja.nombre}}</td>
                    <td>{{caja.created_at}}</td>
                    <td>
                      <button type="button" class="btn btn-primary rounded-pill">NO se aun</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style src="./caja.css"></style>
<script src="./caja.js"></script>
