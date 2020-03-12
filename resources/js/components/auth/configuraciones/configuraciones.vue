<template>
  <div class="container">
    <div class="row my-3">
      <div class="col-md-12">
        <div class="card">
          <div class="container-fluid">
            <h3 class="text-center mt-2">Configuraciones</h3>
            <div class="row justify-center my-3">
              <!-- <div class="col-lg-12 text-center mb-3"> -->
              <div class="col-lg-6">
                <button
                  type="button"
                  class="btn btn-primary btn-lg btn-block"
                  data-toggle="modal"
                  data-target="#staticBackdropUsuarios"
                >Crear Usuarios</button>
              </div>
              <div class="col-lg-6">
                <button type="button" class="btn btn-primary btn-lg btn-block">Block level button 2</button>
              </div>
              <!-- </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Usuarios -->
    <div
      class="modal fade"
      id="staticBackdropUsuarios"
      data-backdrop="static"
      tabindex="-1"
      role="dialog"
      aria-labelledby="staticBackdropUsuarios"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropUsuarios">Usuarios Sucursal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-center">
              
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
            <button
              type="button"
              class="btn btn-success rounded-pill"
            >Guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style src="./configuraciones.css"></style>
<script src="./configuraciones.js"></script>