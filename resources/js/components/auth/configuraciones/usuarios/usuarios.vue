<template>
  <div class="container">
    <div class="row my-3">
      <div class="col-md-12">
        <div class="card">
          <div class="container-fluid">
            <h3 class="text-center mt-2">Usuarios</h3>
            <div class="row justify-center my-3">
              <div class="form-group col-md-6">
                <select class="form-control" :disabled="bloquear" v-model="sucursal">
                  <option value="0">Seleccione una Sucursal</option>
                  <option
                    v-for="option in select_sucursal"
                    v-bind:value="option.id"
                    :key="option.id"
                  >{{option.descripcion}}</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <select class="form-control" v-model="rol">
                  <option value="0">Seleccione un Rol</option>
                  <option
                    v-for="option in select_rol"
                    v-bind:value="option.id"
                    :key="option.id"
                  >{{option.rol}}</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Rut"
                    aria-label="Rut"
                    aria-describedby="rut-label"
                    v-model="rut"
                  />
                </div>
              </div>

              <div class="form-group col-md-4">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Nombres"
                    aria-label="Nombres"
                    aria-describedby="nombres-label"
                    v-model="nombres"
                  />
                </div>
              </div>
              <div class="form-group col-md-4">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Apellidos"
                    aria-label="Apellidos"
                    aria-describedby="apellidos-label"
                    v-model="apellidos"
                  />
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Direccion"
                    aria-label="Direccion"
                    aria-describedby="direccion-label"
                    v-model="direccion"
                  />
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Correo"
                    aria-label="Correo"
                    aria-describedby="correo-label"
                    v-model="correo"
                  />
                </div>
              </div>
              <div class="form-group col-md-12 text-center">
                <button type="button" class="btn btn-success rounded-pill">Guardar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style src="./usuarios.css"></style>
<script src="./usuarios.js"></script>