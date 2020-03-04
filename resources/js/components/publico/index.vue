<template>
  <section id="cover" class="min-vh-100">
    <div id="cover-caption">
      <div class="container">
        <div class="row text-white">
          <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
            <h1 class="display-6 py-2">Formulario de Ingreso Neo RestoBar</h1>
            <div class="px-2">
              <!-- <form class="justify-content-center"> -->
              <div class="form-label-group">
                <input
                  v-model="rut"
                  type="text"
                  class="form-control"
                  placeholder="Ingrese su rut"
                  required
                  autofocus
                />
                <label for="inputEmail">Rut</label>
              </div>
              <div class="form-label-group">
                <input
                  v-model="password"
                  type="password"
                  class="form-control"
                  placeholder="Ingrese su contraseña"
                  required
                />
                <label for="inputPassword">Contraseña</label>
              </div>
              <button
                class="btn btn-lg btn-primary btn-block"
                @click="login()"
                type="submit"
              >Ingresar</button>
              <a class="float-left text-white mt-2">Olvidaste tu Contraseña</a>
              <!-- </form> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style src="./index.css"></style>
<script src="./index.js"></script>

