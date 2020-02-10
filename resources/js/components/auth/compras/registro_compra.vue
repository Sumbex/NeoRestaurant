<template>
  <div class="container">
    <div class="row my-3">
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
              />
              <div class="input-group-append">
                <button
                  class="btn btn-outline-secondary"
                  data-toggle="modal"
                  data-target="#staticBackdrop"
                  type="button"
                  id="boton-modal-insumo"
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
                    v-model="cantidad"
                  />
                  <div class="input-group-append">
                    <span class="input-group-text" id="cantidad-label">Unidad</span>
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
                    v-model="precio"
                  />
                </div>
              </div>
            </div>
            <div class="form-group col-md-12 mt-2 mb-3 text-center">
              <button type="button" class="btn btn-success rounded-pill">Añadir</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
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
      </div>
    </div>

    <!--     <div class="row justify-center my-3">
      <div class="card col-md-4">
        <div class="form-row justify-center">
          <div class="col-12 my-1">
            <h3 class="text-center">Sucursales</h3>
          </div>
          <div class="col-12 my-1">
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
    </div>
    -->
    <div class="row justify-center my-3">
      <div class="card col-md-8">
        <div class="row justify-center">
          <div class="col-md-12 my-1">
            <h3 class="text-center">Tabla</h3>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Insumo</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Unidad</th>
                    <th scope="col">Medida</th>
                    <th scope="col">Cantidad Medida</th>
                    <th scope="col">Opciones</th>
                  </tr>
                </thead>
                <!-- <tbody>
                  <tr v-for="data in insumos" :prop="data" :key="data.id">
                    <th scope="row">{{data.id}}</th>
                    <td>{{data.insumo}}</td>
                    <td>{{data.categoria}}</td>
                    <td>{{data.unidad}}</td>
                    <td>{{data.medida}}</td>
                    <td>{{data.cantidad}}</td>
                    <td>{{data.nombre}}</td>
                    <td>{{data.created_at}}</td>
                  </tr>
                </tbody>-->
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- <div class="row justify-center my-3 ">
      <div class="card col-md-4">
        <div class="form-row justify-center">
          <div class="col-12 my-1">
            <h3 class="text-center">Sucursales</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-center my-3">
      <div class="card col-md-4">
        <div class="form-row justify-center">
          <div class="col-12 my-1">
            <h3 class="text-center">Proveedor</h3>
          </div>
        </div>
      </div>
    </div>-->
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
            <h5 class="modal-title" id="staticBackdropLabel">Categoria de insumos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-center">
              <div class="col-12 my-1">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Tipo de Insumo"
                  aria-label="Insumo"
                  v-model="categoria"
                />
              </div>
              <div class="col-12 mt-2">
                <div class="table-responsive">
                  <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Creada por:</th>
                        <th scope="col">Creada</th>
                        <th scope="col">Opciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="cat in categorias" :prop="cat" :key="cat.id">
                        <th scope="row">{{cat.id}}</th>
                        <td>{{cat.insumo}}</td>
                        <td>{{cat.nombre}}</td>
                        <td>{{cat.created_at}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
            <button
              type="button"
              class="btn btn-success rounded-pill"
              @click="ingresarCategorias()"
            >Guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style src="./registro_compra.css"></style>
<script src="./registro_compra.js"></script>
