<template>
  <div class="container">
    <div class="row justify-center my-3">
      <div class="card col-md-12">
        <div class="form-row justify-center">
          <div class="col-12 my-1">
            <h3 class="text-center">Formulario</h3>
          </div>
          <div class="input-group my-1">
            <div class="form-group col-md-4">
              <input
                type="text"
                class="form-control"
                placeholder="Rut del Proveedor"
                aria-label="Rut"
                v-model="rut"
              />
            </div>
            <div class="form-group col-md-8">
              <input
                type="text"
                class="form-control"
                placeholder="Razon Social"
                aria-label="Razon"
                v-model="razon"
              />
            </div>
            <div class="form-group col-md-6">
              <input
                type="text"
                class="form-control"
                placeholder="Direccion"
                aria-label="Direccion"
                v-model="direccion"
              />
            </div>
            <div class="form-group col-md-6">
              <input
                type="text"
                class="form-control"
                placeholder="Pagina Web"
                aria-label="Pagina"
                v-model="pagina"
              />
            </div>
            <div class="form-group col-md-4">
              <input
                type="text"
                class="form-control"
                placeholder="Nombre del Contacto"
                aria-label="Contacto"
                v-model="contacto"
              />
            </div>
            <div class="form-group col-md-4">
              <input
                type="text"
                class="form-control"
                placeholder="N° Telefono"
                aria-label="fono"
                v-model="fono"
              />
            </div>
            <div class="form-group col-md-4">
              <input
                type="text"
                class="form-control"
                placeholder="Correo"
                aria-label="Correo"
                v-model="correo"
              />
            </div>
            <div class="form-group col-md-12 mt-2 mb-3 text-center">
              <button
                type="button"
                class="btn btn-success rounded-pill"
                @click="ingresarProveedor()"
              >Guardar</button>
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
                    <th scope="col">Rut</th>
                    <th scope="col">Razon Social</th>
                    <th scope="col">Direccion</th>
                    <th scope="col">Pagina</th>
                    <th scope="col">Contacto</th>
                    <th scope="col">N° Telefono</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Creada por:</th>
                    <th scope="col">Creada:</th>
                    <th scope="col">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="proveedor in proveedores" :prop="proveedor" :key="proveedor.id">
                    <th scope="row">{{proveedor.id}}</th>
                    <td>{{proveedor.rut}}</td>
                    <td>{{proveedor.razon}}</td>
                    <td>{{proveedor.direccion}}</td>
                    <td>{{proveedor.pagina}}</td>
                    <td>{{proveedor.contacto}}</td>
                    <td>{{proveedor.fono}}</td>
                    <td>{{proveedor.correo}}</td>
                    <td>{{proveedor.nombre}}</td>
                    <td>{{proveedor.created_at}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style src="./proveedor.css"></style>
<script src="./proveedor.js"></script>
