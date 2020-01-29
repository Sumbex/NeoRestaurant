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
              <select class="form-control" v-model="sucursal">
                <option value="0">Seleccione una Sucursal</option>
                <option
                  v-for="option in select_sucursal"
                  v-bind:value="option.id"
                  :key="option.id"
                >{{option.descripcion}}</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <select class="form-control">
                <option value="0">Seleccione una Zona</option>
              </select>
            </div>
            <div class="form-group col-md-12 text-center">
              <div class="custom-control custom-radio custom-control-inline">
                <input
                  type="radio"
                  id="customRadioInline1"
                  name="customRadioInline1"
                  class="custom-control-input"
                  v-model="radio"
                  v-bind:value="true"
                  @change="estado()"
                />
                <label class="custom-control-label" for="customRadioInline1">Individual</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input
                  type="radio"
                  id="customRadioInline2"
                  name="customRadioInline1"
                  class="custom-control-input"
                  v-model="radio"
                  v-bind:value="false"
                  @change="estado()"
                />
                <label class="custom-control-label" for="customRadioInline2">Multiple</label>
              </div>
            </div>
            <div class="form-group col-md-6">
              <input
                type="text"
                class="form-control"
                placeholder="Nombre/Numero Mesa"
                aria-label="Mesa"
                :disabled="!disabled"
              />
            </div>
            <div class="form-group col-md-6">
              <input
                type="text"
                class="form-control"
                placeholder="Cantidad de Mesas"
                aria-label="Mesas"
                :disabled="disabled"
              />
            </div>
            <div class="form-group col-md-12 mt-2 mb-3 text-center">
              <button
                type="button"
                class="btn btn-primary rounded-pill"
                data-toggle="modal"
                data-target="#staticBackdrop"
              >Agregar Zonas</button>
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
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">First</th>
                  <th scope="col">Last</th>
                  <th scope="col">Handle</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>Larry</td>
                  <td>the Bird</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>
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
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Zonas Mesas</h5>
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
              <div class="col-12 mt-2">
                <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Descripcion</th>
                      <th scope="col">Opcion</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">1</th>
                      <td>Mark</td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
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

<style src="./mesas.css"></style>
<script src="./mesas.js"></script>