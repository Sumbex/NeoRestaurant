<template>
  <div class="container">
    <div class="row my-3">
      <div class="col-md-12">
        <div class="card mb-3">
          <div class="container-fluid">
            <h3 class="text-center">Tabla</h3>
            <div class="row justify-center">
              <div class="col-lg-4">
                <div class="form-group">
                  <select class="form-control" v-model="anio" @change="traerCompras()">
                    <option value="0">Seleccione el Año</option>
                    <option
                      v-for="option in anios"
                      v-bind:value="option.id"
                      :key="option.id"
                    >{{option.descripcion}}</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <select class="form-control" v-model="mes" @change="traerCompras()">
                    <option value="0">Seleccione el Mes</option>
                    <option
                      v-for="option in meses"
                      v-bind:value="option.id"
                      :key="option.id"
                    >{{option.descripcion}}</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <select class="form-control" v-model="almacen" @change="traerCompras()">
                    <option value="0">Seleccione el Almacen</option>
                    <option
                      v-for="option in almacenes"
                      v-bind:value="option.id"
                      :key="option.id"
                    >{{option.sucursal}}</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="table-responsive">
                  <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col">N° Documento</th>
                        <th scope="col">Comprobante</th>
                        <th scope="col">Total</th>
                        <th scope="col">Creada por:</th>
                        <th scope="col">Creada:</th>
                        <th scope="col">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="compra in compras" :prop="compra" :key="compra.id">
                        <th scope="row">{{compra.id}}</th>
                        <td>{{compra.proveedor}}</td>
                        <td>{{compra.comprobante}}</td>
                        <td>
                          <button type="button" class="btn btn-primary rounded-pill">Ver Archivo</button>
                        </td>
                        <td>{{compra.total}}</td>
                        <td>{{compra.nombre}}</td>
                        <td>{{compra.created_at}}</td>
                        <td>
                          <button
                            type="button"
                            class="btn btn-primary rounded-pill"
                            data-toggle="modal"
                            data-target="#staticBackdrop"
                            @click="traerDetalle(compra.id)"
                          >Ver Detalle</button>
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
            <h5 class="modal-title" id="staticBackdropLabel">Detalle</h5>
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
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        <th scope="col">SubTotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="data in detalles" :prop="data" :key="data.id">
                        <th scope="row">{{data.id}}</th>
                        <td>{{data.insumo}}</td>
                        <td>{{data.cantidad}}</td>
                        <td>{{data.precio}}</td>
                        <td>{{data.subtotal}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-group col-md-12 mt-3 mb-3 text-center">
                <h1>{{total}} Pesos.</h1>
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

<style src="./ver_compras.css"></style>
<script src="./ver_compras.js"></script>
