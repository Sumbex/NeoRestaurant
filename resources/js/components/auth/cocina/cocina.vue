<template>
  <div class="container">
    <div class="row justify-center my-3">
      <div class="card col-md-12">
        <div class="form-row justify-center">
          <div class="col-12 my-1">
            <h3 class="text-center">Cocina</h3>
          </div>
          <!-- <div class="input-group my-1">
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
              <select class="form-control" v-model="zonas">
                <option value="0">Seleccione una Zona</option>
                <option
                  v-for="option in select_zonas"
                  v-bind:value="option.id"
                  :key="option.id"
                >{{option.zona}}</option>
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
                  @change="estado(), cantMesa = null"
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
                  @change="estado(), mesa = null"
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
                v-model="mesa"
              />
            </div>
            <div class="form-group col-md-6">
              <input
                type="text"
                class="form-control"
                placeholder="Cantidad de Mesas"
                aria-label="Mesas"
                :disabled="disabled"
                v-model="cantMesa"
              />
            </div>
            <div class="form-group col-md-12 mt-2 mb-3 text-center">
              <button
                type="button"
                class="btn btn-primary rounded-pill"
                data-toggle="modal"
                data-target="#staticBackdrop"
                @click="traerZonas()"
              >Agregar Zonas</button>
              <button
                type="button"
                class="btn btn-success rounded-pill"
                @click="ingresarMesa()"
              >Guardar</button>
            </div>
          </div>-->
        </div>
      </div>
    </div>
    <!-- Modal -->
    <!-- <div
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
                  v-model="zona"
                />
              </div>
              <div class="col-12 mt-2">
                <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Zona</th>
                      <th scope="col">Creada por:</th>
                      <th scope="col">Creada</th>
                      <th scope="col">Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="zonas in zonasModal" :prop="zonas" :key="zonas.id">
                      <th scope="row">{{zonas.id}}</th>
                      <td>{{zonas.zona}}</td>
                      <td>{{zonas.nombre}}</td>
                      <td>{{zonas.created_at}}</td>
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
              @click="ingresarZonas()"
            >Guardar</button>
          </div>
        </div>
      </div>
    </div>-->
  </div>
</template>

<style src="./cocina.css"></style>
<script src="./cocina.js"></script>