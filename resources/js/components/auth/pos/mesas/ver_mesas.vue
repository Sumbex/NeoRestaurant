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
            <div class="row justify-center">
              <div class="col-12 my-1">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Zona de la Mesa"
                  aria-label="Zona"
                />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success rounded-pill">Guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style src="./ver_mesas.css"></style>
<script src="./ver_mesas.js"></scri+pt>
