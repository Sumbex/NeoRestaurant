<template>
  <div class="container-fluid">
    <div class="wrapper">
      <div class="row justify-center my-3">
        <!-- sidebar -->
        <div class="column col-md-4 order-md-2" id="sidebar">
          <div class="card mb-3">
            <div class="container-fluid" v-show="!estado">
              <h3 class="text-center mt-2">Apertura de Mesa</h3>
              <div class="row justify-center">
                <div class="col-lg-12 mb-3">
                  <h5 class="text-center">Mesa # {{mesa.mesa}}</h5>
                </div>
              </div>
              <div class="form-group col-md-12 mb-3 text-center">
                <button
                  type="button"
                  class="btn btn-primary btn-sm btn-block"
                  @click="abrirCerrarMesa()"
                >Abrir Mesa</button>
              </div>
            </div>
            <div class="container-fluid" v-show="estado">
              <div v-show="estadoMesa == 2">
                <h3 class="text-center mt-2">Toma de Pedido</h3>
                <div class="row justify-center">
                  <div class="col-lg-12 mb-3">
                    <h5 class="text-center">Mesa # {{mesa.mesa}}</h5>
                  </div>
                </div>
                <div class="row justify-center mt-3 mb-1">
                  <div class="col-sm-12">
                    <label>
                      <strong>Hora del Pedido:</strong>
                    </label>
                    <!-- <label class="text-right">15:25</label> -->
                  </div>
                  <div class="col-sm-12">
                    <label>
                      <strong>Estado del Pedido:</strong>
                    </label>
                    <!-- <label class="text-right">Atendido</label> -->
                  </div>
                  <div class="col-sm-12 text-center">
                    <label>
                      <h5>
                        <strong>Pedido</strong>
                      </h5>
                    </label>
                  </div>
                  <div class="form-group col-md-12 mb-3 text-center">
                    <button
                      type="button"
                      class="btn btn-primary btn-sm btn-block"
                      data-toggle="modal"
                      data-target="#staticBackdrop"
                      @click="añadirMesa(true, null)"
                    >Tomar Pedido</button>
                    <button
                      type="button"
                      class="btn btn-danger btn-sm btn-block"
                      @click="abrirCerrarMesa()"
                    >Cerrar Mesa</button>
                  </div>
                </div>
              </div>
              <div v-show="estadoMesa == 3">
                <div class="row justify-center mt-3 mb-1">
                  <div class="col-sm-12 text-center">
                    <h4>Pedido</h4>
                  </div>
                  <div class="col-sm-12">
                    <label>
                      <strong>Hora del Pedido:</strong>
                    </label>
                    <!-- <label class="text-right">15:25</label> -->
                  </div>
                  <div class="col-sm-12">
                    <label>
                      <strong>Estado del Pedido:</strong>
                    </label>
                    <!-- <label class="text-right">Atendido</label> -->
                  </div>
                  <div class="col-sm-12 text-center">
                    <label>
                      <h5>
                        <strong>Pedido</strong>
                      </h5>
                    </label>
                  </div>
                </div>
                <div
                  class="row justify-center mb-2"
                  v-for="pedido in pedidos"
                  prop="pedido"
                  :key="pedido.id"
                >
                  <!-- array del pedido -->
                  <div class="col-sm-12">
                    <label>
                      <strong>{{pedido.cantidad}}</strong>
                      x {{pedido.producto}}
                    </label>
                    <label class="text-right">${{pedido.precio}} c/u</label>
                  </div>
                  <!-- array del pedido -->
                </div>

                <div class="row justify-center mb-2">
                  <div class="col-sm-12">
                    <label>
                      <strong>Total</strong>
                    </label>
                    <label class="text-right">${{total}}</label>
                  </div>
                </div>
                <div class="form-group col-md-12 mb-3 text-center">
                  <button
                    type="button"
                    class="btn btn-primary btn-sm btn-block"
                    data-toggle="modal"
                    data-target="#staticBackdrop"
                    @click="añadirMesa(true, null)"
                  >Actualizar Pedido</button>
                  <button
                    type="button"
                    class="btn btn-danger btn-sm btn-block"
                    @click="abrirCerrarMesa()"
                  >Pagar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- main -->
        <div class="column col-md-8" id="main">
          <div class="col-sm-12 text-center">
            <h2>Mesas</h2>
          </div>

          <div class="col-sm-12 my-1" v-for="zona in zonas" prop="zona" :key="zona">
            <div class="card mb-3">
              <div class="card-body">
                <h3 class="card-title text-center">{{zona}}</h3>
                <div class="row justify-center my-3">
                  <div class="col-sm-2" v-for="data in mesas[zona]" prop="data" :key="data.id">
                    <div class="card border-info mb-3">
                      <a
                        class="text-white"
                        style="text-decoration:none"
                        @click="seleccionarMesa(data), idMesa = data.id"
                      >
                        <div class="card-body text-info">
                          <img class="card-img-top" src="/images/silla.png" />
                          <h4 class="card-text text-center">{{data.mesa}}</h4>
                        </div>
                      </a>
                    </div>
                  </div>
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
            <h5 class="modal-title" id="staticBackdropLabel">Nuevo Pedido {{idMesa}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-5">
                <div class="card">
                  <div class="container-fluid">
                    <div class="row justify-center mt-3 mb-1">
                      <div class="col-lg-12">
                        <!-- pedidoMesas -->
                        <button
                          type="button"
                          class="btn btn-primary"
                          disabled
                          v-for="data in pedidoMesas"
                          prop="data"
                          :key="data.id"
                        >Mesa {{data.mesa}}</button>
                      </div>
                      <div class="col-lg-12">
                        <div class="dropdown">
                          <a
                            class="btn btn-primary dropdown-toggle"
                            href="#"
                            role="button"
                            id="dropdownAgregar"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >Agregar Mesa</a>

                          <div class="dropdown-menu" aria-labelledby="dropdownAgregar">
                            <a
                              class="dropdown-item"
                              v-for="data in mesasDrop"
                              prop="data"
                              :key="data.id"
                              @click="añadirMesa(false, data)"
                            >Mesa {{data.mesa}}</a>
                          </div>
                        </div>

                        <div class="dropdown">
                          <a
                            class="btn btn-danger dropdown-toggle"
                            href="#"
                            role="button"
                            id="dropdownQuitar"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >Quitar Mesa</a>

                          <div class="dropdown-menu" aria-labelledby="dropdownQuitar">
                            <a
                              class="dropdown-item"
                              v-for="data in mesasDrop"
                              prop="data"
                              :key="data.id"
                              @click="quitarMesa(data.id)"
                            >Mesa {{data.mesa}}</a>
                          </div>
                        </div>
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
                        <!-- <label class="text-right">15:25</label> -->
                      </div>
                      <div class="col-sm-12">
                        <label>
                          <strong>Estado del Pedido:</strong>
                        </label>
                        <!-- <label class="text-right">Atendido</label> -->
                      </div>
                      <div class="col-sm-12 text-center">
                        <label>
                          <h5>
                            <strong>Pedido</strong>
                          </h5>
                        </label>
                      </div>
                    </div>
                    <div
                      class="row justify-center mb-2"
                      v-for="pedido in pedidos"
                      prop="pedido"
                      :key="pedido.id"
                    >
                      <!-- array del pedido -->
                      <div class="col-sm-12">
                        <label>
                          <strong>{{pedido.cantidad}}</strong>
                          x {{pedido.producto}}
                        </label>
                        <label class="text-right">${{pedido.precio}} c/u</label>
                      </div>
                      <!-- array del pedido -->
                    </div>

                    <div class="row justify-center mb-2">
                      <div class="col-sm-12">
                        <label>
                          <strong>Total</strong>
                        </label>
                        <label class="text-right">${{total}}</label>
                      </div>
                    </div>

                    <div class="form-group col-md-12 mb-3 text-center">
                      <button
                        type="button"
                        class="btn btn-primary btn-sm btn-block"
                        @click="ingresarPedido()"
                      >Realizar Pedido</button>
                      <!-- <button
                        type="button"
                        class="btn btn-primary btn-sm btn-block"
                      >Actualizar Pedido</button>
                      <button type="button" class="btn btn-secondary btn-sm btn-block">Pagar</button>-->
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
                        @click="verificarStock(producto)"
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
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
          </div>-->
        </div>
      </div>
    </div>
  </div>
</template>

<style src="./ver_mesas.css"></style>
<script src="./ver_mesas.js"></script>
