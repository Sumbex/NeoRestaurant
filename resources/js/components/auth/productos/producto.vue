<template>
  <div class="container">
    <div class="row my-3">
      <div class="col-md-12">
        <div class="card">
          <div class="container-fluid">
            <h3 class="text-center">Sucursales</h3>
            <div class="row justify-center">
              <div class="col-lg-12 text-center mb-3">
                <div
                  class="custom-control custom-switch custom-control-inline"
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
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row my-3">
      <div class="col-md-6">
        <div class="card mb-3">
          <div class="container-fluid">
            <h3 class="text-center mt-2">Insumo</h3>
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
              <div class="col-lg-12 mt-2">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Cantidad"
                    aria-label="Cantidad"
                    aria-describedby="cantidad-label"
                    v-model.number="insumo.cantidad"
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
            </div>
            <div class="form-group col-md-12 mt-3 mb-3 text-center">
              <button type="button" class="btn btn-success rounded-pill" @click="añadirCarro()">
                <span v-show="!boton">Añadir</span>
                <span v-show="boton">Guardar</span>
              </button>
              <button type="button" class="btn btn-danger rounded-pill">Limpiar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-3">
          <div class="container-fluid">
            <h3 class="text-center mt-2">Producto</h3>
            <div class="row">
              <div class="col-lg-12 mb-3">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Producto"
                    aria-label="Producto"
                    aria-describedby="producto-label"
                    v-model.number="producto"
                  />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <select class="form-control" v-model="categoria">
                    <option value="0">Seleccione la categoria</option>
                    <option
                      v-for="option in categoria_select"
                      v-bind:value="option.id"
                      :key="option.id"
                    >{{option.descripcion}}</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <select class="form-control" v-model="destino">
                    <option value="0">Seleccione el Destino</option>
                    <option value="1">Restaurant</option>
                    <option value="2">Bar</option>
                    <!-- <option
                      v-for="option in destino_select"
                      v-bind:value="option.id"
                      :key="option.id"
                    >{{option.razon}}</option>-->
                  </select>
                </div>
              </div>
              <div class="col-lg-7 mb-3">
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input"
                    id="customFile"
                    @change="onFileChange"
                  />
                  <label
                    class="custom-file-label"
                    for="customFile"
                    data-browse="Elegir"
                  >Seleccionar Archivo</label>
                </div>
              </div>
              <div class="col-lg-5 mb-3">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Precio"
                    aria-label="Precio"
                    aria-describedby="precio-label"
                    v-model.number="precio"
                  />
                </div>
              </div>
            </div>
            <div class="form-group col-md-12 mb-3 text-center">
              <button
                type="button"
                class="btn btn-primary rounded-pill"
                data-toggle="modal"
                data-target="#staticBackdropCategoria"
                @click="traerCategorias()"
              >Agregar Categorias</button>
              <button
                type="button"
                class="btn btn-success rounded-pill"
                @click="ingresarProducto()"
              >Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row my-3">
      <div class="col-md-12">
        <div class="card mb-3">
          <div class="container-fluid">
            <h3 class="text-center">Carro</h3>

            <div class="table-responsive">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Insumo</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Medida</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data,index) in carro" :prop="data" :key="data.id">
                    <th scope="row">{{data.id}}</th>
                    <td>{{data.insumo}}</td>
                    <td>{{data.cantidad}}</td>
                    <td>Unidad</td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-primary rounded-pill"
                        @click="modificarItem(index)"
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
    </div>

    <!-- Modal Insumo -->
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
    <!-- Modal Categoria -->
    <div
      class="modal fade"
      id="staticBackdropCategoria"
      data-backdrop="static"
      tabindex="-1"
      role="dialog"
      aria-labelledby="staticBackdropCategoria"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropCategoria">Categoria de insumos</h5>
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
                  placeholder="Tipo de Producto"
                  aria-label="Producto"
                  v-model="cateDesc"
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
                        <td>{{cat.producto}}</td>
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

<style src="./producto.css"></style>
<script src="./producto.js"></script>
