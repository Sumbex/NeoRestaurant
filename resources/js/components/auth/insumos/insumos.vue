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
                class="form-control"
                placeholder="Nombre del Insumo"
                aria-label="Insumo"
                v-model="insumo"
              />
            </div>
            <div class="form-group col-md-6">
              <select class="form-control" v-model="unidad">
                <option value="0">Seleccione una Unidad</option>
                <option value="1">Botella</option>
                <option value="2">Lata</option>
                <option value="3">Kilo</option>
                <option value="4">Bolsa</option>
                <option value="5">Unidad</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <select class="form-control" v-model="catInsumo">
                <option value="0">Seleccione una Categoria</option>
                <option
                  v-for="option in catInsumoSelect"
                  v-bind:value="option.id"
                  :key="option.id"
                >{{option.descripcion}}</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <select class="form-control" v-model="medida">
                <option value="0">Seleccione una Medida</option>
                <option value="1">ML</option>
                <option value="2">CC</option>
                <option value="3">GR</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <input
                type="text"
                class="form-control"
                placeholder="Cantidad por Medida"
                aria-label="Cantidad"
                v-model="cantidad"
              />
            </div>
            <div class="form-group col-md-4">
              <input
                type="text"
                class="form-control"
                placeholder="Stock Minimo"
                aria-label="Stock"
                v-model="stock"
              />
            </div>
            <div class="form-group col-md-4">
              <input
                type="text"
                class="form-control"
                placeholder="Precio Compra"
                aria-label="Precio"
                v-model="precio"
              />
            </div>
            <div class="form-group col-md-12 mt-2 mb-3 text-center">
              <button
                type="button"
                class="btn btn-primary rounded-pill"
                data-toggle="modal"
                data-target="#staticBackdrop"
                @click="traerCategorias()"
              >Agregar Categorias</button>
              <button type="button" class="btn btn-success rounded-pill">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-center my-3">
      <div class="card col-md-12">
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
                    <th scope="col">Mesa</th>
                    <th scope="col">Sucursal</th>
                    <th scope="col">Zona</th>
                    <th scope="col">Creada por:</th>
                    <th scope="col">Creada:</th>
                    <th scope="col">Opciones</th>
                  </tr>
                </thead>
                <!-- <tbody>
                  <tr v-for="mesa in mesas" :prop="mesa" :key="mesa.id">
                    <th scope="row">{{mesa.id}}</th>
                    <td>{{mesa.mesa}}</td>
                    <td>{{mesa.sucursal}}</td>
                    <td>{{mesa.zona}}</td>
                    <td>{{mesa.nombre}}</td>
                    <td>{{mesa.created_at}}</td>
                  </tr>
                </tbody>-->
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

<style src="./insumos.css"></style>
<script src="./insumos.js"></script>
