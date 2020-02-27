<template>
  <div class="container">
    <div class="row justify-center my-3">
      <div class="col-sm-12 text-center">
        <h2>Seleccione una Mesa</h2>
      </div>

      <div class="col-sm-12 my-1" v-for="zona in zonas" prop="zona" :key="zona">
        <div class="card mb-3">
          <div class="card-body">
            <h3 class="card-title text-center">{{zona}}</h3>
            <div class="row justify-center my-3">
              <div class="col-sm-2" v-for="mesa in mesas[zona]" prop="mesa" :key="mesa.id">
                <div class="card border-info mb-3">
                  <a
                    class="text-white"
                    style="text-decoration:none"
                    data-toggle="modal"
                    data-target="#staticBackdrop"
                    @click="idMesa = mesa.id"
                  >
                    <div class="card-body text-info">
                      <img class="card-img-top" src="/images/silla.png" />
                      <h4 class="card-text text-center">{{mesa.mesa}}</h4>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--  <div class="row justify-center my-5" v-show="!tabla">
      <div class="loader"></div>
    </div-->

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
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Realizar Orden {{idMesa}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-5">
                <div class="card mb-3">
                  <div class="container-fluid">
                    <div class="row justify-center mt-3 mb-1">
                      <div class="col-lg-12">
                        <button type="button" class="btn btn-primary">Mesa 1</button>
                        <button type="button" class="btn btn-primary">Mesa 2</button>
                        <button type="button" class="btn btn-info">Agregar Mesa</button>
                        <button type="button" class="btn btn-info">Quitar Mesa</button>
                      </div>
                    </div>
                    <div class="row justify-center mt-3 mb-1">
                      <div class="col-sm-12 text-center">
                        <h4>Toma de Pedido</h4>
                      </div>
                      <div class="col-sm-12">
                        <label>
                          <strong>Hora del Pedido:</strong>
                        </label>
                        <label class="text-right">15:25</label>
                      </div>
                      <div class="col-sm-12">
                        <label>
                          <strong>Estado del Pedido:</strong>
                        </label>
                        <label class="text-right">Atendido</label>
                      </div>
                      <div class="col-sm-12">
                        <label>
                          <strong>Pedido</strong>
                        </label>
                      </div>
                      <!-- array del pedido -->
                      <div class="col-sm-12">
                        <label>
                          <strong>1</strong>
                          x Producto
                        </label>
                        <label class="text-right">$2990 c/u</label>
                      </div>
                      <!-- array del pedido -->
                      <div class="col-sm-12">
                        <label>
                          <strong>Total</strong>
                        </label>
                        <label class="text-right">$2990 c/u</label>
                      </div>
                    </div>
                    <div class="form-group col-md-12 mb-3 text-center">
                      <button
                        type="button"
                        class="btn btn-primary btn-sm btn-block"
                      >Actualizar Pedido</button>
                      <button type="button" class="btn btn-secondary btn-sm btn-block">Pagar</button>
                      <!-- <button type="button" class="btn btn-primary rounded-pill"></button>
                      <button type="button" class="btn btn-success rounded-pill"></button>-->
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="card">
                  <div class="container-fluid">
                    <div class="row justify-center mt-3 mb-1">
                      <div class="col-lg-5">
                        <div class="form-group">
                          <select
                            class="form-control"
                            v-model="categoria"
                            @change="traerProductos()"
                          >
                            <option value="0">Todos</option>
                            <option
                              v-for="option in categorias"
                              v-bind:value="option.id"
                              :key="option.id"
                            >{{option.descripcion}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-7">
                        <div class="input-group">
                          <input
                            type="text"
                            class="form-control"
                            placeholder="Buscar"
                            aria-label="Buscar"
                            aria-describedby="buscar-label"
                            v-model="buscar"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row justify-center mb-3">
                      <div
                        class="col-sm-3 pointer"
                        v-for="producto in productos"
                        prop="producto"
                        :key="producto.id"
                      >
                        <div class="card bg-dark text-white">
                          <img :src="'/'+producto.foto" class="card-img" :alt="producto.producto" />
                          <div class="card-img-overlay">
                            <h5 class="card-title text-center">{{producto.producto}}</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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

<style src="./ver_mesas.css"></style>
<script src="./ver_mesas.js"></script>
