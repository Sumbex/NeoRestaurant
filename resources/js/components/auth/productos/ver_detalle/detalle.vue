<template>
  <div class="container">
    <div class="row my-3">
      <div class="col-md-12">
        <div class="card mb-3">
          <div class="container-fluid">
            <h3 class="text-center">Tabla</h3>
            <div class="col-lg-12">
              <div class="form-group">
                <select class="form-control" v-model="almacen" @change="traerProductos()">
                  <option value="0">Seleccione el Almacen</option>
                  <option
                    v-for="option in almacenes"
                    v-bind:value="option.id"
                    :key="option.id"
                  >{{option.sucursal}}</option>
                </select>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Destino</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Creada por:</th>
                    <th scope="col">Creada:</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="producto in productos" :prop="producto" :key="producto.id">
                    <th scope="row">{{producto.id}}</th>
                    <td>{{producto.producto}}</td>
                    <td>{{producto.categoria}}</td>
                    <td>{{producto.destino}}</td>
                    <td>
                      <button type="button" class="btn btn-primary rounded-pill">Ver Foto</button>
                    </td>
                    <td>{{producto.precio}}</td>
                    <td>{{producto.nombre}}</td>
                    <td>{{producto.created_at}}</td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-primary rounded-pill"
                        data-toggle="modal"
                        data-target="#staticBackdrop"
                        @click="traerDetalle(producto.id)"
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
                        <th scope="col">Unidad</th>
                        <th scope="col">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="data in detalles" :prop="data" :key="data.id">
                        <th scope="row">{{data.id}}</th>
                        <td>{{data.insumo}}</td>
                        <td>{{data.cantidad}}</td>
                        <td>{{data.unidad_id}}</td>
                        <td>
                          <button type="button" class="btn btn-success rounded-pill">Modificar</button>
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

<style src="./detalle.css"></style>
<script src="./detalle.js"></script>
