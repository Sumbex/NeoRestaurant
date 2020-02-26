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
                    <th scope="col">Estado</th>
                    <th scope="col">Creada por:</th>
                    <th scope="col">Creada</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="caja in cajas" :prop="caja" :key="caja.id">
                    <th scope="row">{{caja.id}}</th>
                    <td>{{caja.caja}}</td>
                    <td>{{caja.estado}}</td>
                    <td>{{caja.nombre}}</td>
                    <td>{{caja.created_at}}</td>
                    <td>
                      <button
                        v-show="caja.estado_id == 2"
                        type="button"
                        class="btn btn-primary rounded-pill"
                        data-toggle="modal"
                        data-target="#staticBackdrop"
                        id="boton-modal-insumo"
                        @click="setDatosCaja(caja.id,caja.estado_id)"
                      >Abrir</button>
                      <button
                        v-show="caja.estado_id == 1"
                        type="button"
                        class="btn btn-danger rounded-pill"
                        data-toggle="modal"
                        data-target="#staticBackdrop"
                        id="boton-modal-insumo"
                        @click="setDatosCaja(caja.id,caja.estado_id)"
                      >Cerrar</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="staticBackdrop"
      data-backdrop="static"
      tabindex="-1"
      role="dialog"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Abrir/Cerrar Caja</h5>
            <button
              type="button"
              id="cerrarModal"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-center">
              <div class="col-12 mb-3">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Monto de la Caja"
                    aria-label="Monto"
                    aria-describedby="monto-label"
                    v-model.number="monto"
                  />
                </div>
              </div>
              <!-- <div class="col-12 mb-3">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Contraseña"
                    aria-label="Contraseña"
                    aria-describedby="contraseña-label"
                    v-model.number="pass"
                  />
                </div>
              </div>-->
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
            <button
              type="button"
              class="btn btn-success rounded-pill"
              @click="abrirCerrarCaja()"
            >Abrir/Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style src="./caja.css"></style>
<script src="./caja.js"></script>
