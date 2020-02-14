<template>
  <div class="container">
    <div class="row my-3">
      <div class="col-md-4 order-md-2">
        <div class="card mb-3">
          <div class="container-fluid">
            <h3 class="text-center">Sucursales</h3>
            <div class="row justify-center">
              <div class="col-lg-12 text-center mb-3">
                <div
                  class="custom-control custom-switch"
                  v-for="data in almacenes"
                  :prop="data"
                  :key="data.id"
                >
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    :id="data.sucursal"
                    :value="data.id"
                    v-model="checkAlmacen"
                  />
                  <label class="custom-control-label" :for="data.sucursal">{{data.sucursal}}</label>
                  {{checkAlmacen}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card">
          <div class="container-fluid">
            <h3 class="text-center">Formulario</h3>
            <div class="input-group my-1">
              <input
                type="text"
                class="form-control"
                placeholder="Insumo"
                aria-label="Insumo"
                aria-describedby="boton-modal-insumo"
                disabled
                v-model="insumo.insumo"
              />
              <div class="input-group-append">
                <button
                  class="btn btn-outline-secondary"
                  data-toggle="modal"
                  data-target="#staticBackdrop"
                  type="button"
                  id="boton-modal-insumo"
                  @click="traerInsumos()"
                >
                  Buscar
                  insumo
                </button>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 mt-4">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Cantidad"
                    aria-label="Cantidad"
                    aria-describedby="cantidad-label"
                    v-model.number="cantidad"
                  />
                  <div class="input-group-append">
                    <span class="input-group-text" v-show="activo" id="cantidad-label">Unidad</span>
                    <span
                      class="input-group-text"
                      v-show="!activo"
                      id="cantidad-label"
                    >{{insumo.unidad_id}}</span>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 mt-4">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Precio"
                    aria-label="Precio"
                    v-model="insumo.precio"
                  />
                </div>
              </div>
            </div>
            <div class="form-group col-md-12 mt-3 mb-3 text-center">
              <button
                type="button"
                class="btn btn-success rounded-pill"
                @click="añadirCarro()"
              >Añadir</button>
              <button
                type="button"
                class="btn btn-danger rounded-pill"
                @click="insumo = [], activo = !activo"
              >Limpiar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row my-3">
      <div class="col-md-8">
        <div class="card">
          <div class="container-fluid">
            <h3 class="text-center">Tabla</h3>

            <div class="table-responsive">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Insumo</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Total</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data,index) in carro" :prop="data" :key="data.id">
                    <th scope="row">{{data.id}}</th>
                    <td>{{data.insumo}}</td>
                    <td>{{data.cantidad}}</td>
                    <td>{{data.precio}}</td>
                    <td>{{data.total}}</td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-primary rounded-pill"
                        @click="modificarItem(data)"
                      >Modificar</button>
                      <button
                        type="button"
                        class="btn btn-danger rounded-pill"
                        @click="eliminarItem(index)"
                      >Quitar</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="form-group col-md-12 mt-3 mb-3 text-center">
              <button
                type="button"
                class="btn btn-danger rounded-pill"
                @click="limpiarCarro()"
              >Quitar Todo</button>
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="col-md-4">
        <div class="card">
          <div class="container-fluid">
            <h3 class="text-center">Sucursales</h3>
            <div class="col-lg-12">
              <div
                class="custom-control custom-switch"
                v-for="data in almacenes"
                :prop="data"
                :key="data.id"
              >
                <input
                  type="checkbox"
                  class="custom-control-input"
                  :id="data.sucursal"
                  v-model="data.id"
                />
                <label class="custom-control-label" :for="data.sucursal">{{data.sucursal}}</label>
              </div>
            </div>
          </div>
        </div>
      </div>-->
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
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Seleccionar Insumo</h5>
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
              <div class="col-12 mt-2">
                <div class="table-responsive">
                  <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Insumo</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Unidad</th>
                        <th scope="col">Cent. Medida</th>
                        <th scope="col">Precio Sugerido</th>
                        <th scope="col">Accion</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="data in insumos" :prop="data" :key="data.id">
                        <th scope="row">{{data.id}}</th>
                        <td>{{data.insumo}}</td>
                        <td>{{data.categoria}}</td>
                        <td>{{data.unidad_id}}</td>
                        <td>{{data.cantidad}}</td>
                        <td>{{data.precio}}</td>
                        <td>
                          <button
                            type="button"
                            class="btn btn-success rounded-pill"
                            @click="seleccionarInsumo(data)"
                          >Agregar</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style src="./registro_compra.css"></style>
<script src="./registro_compra.js"></script>
