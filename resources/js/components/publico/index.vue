<template>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <br />
      <h1 class="text-center">Neo RestoBar</h1>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center">Identifíquese</h5>
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
          <button class="btn btn-lg btn-primary btn-block"  @click="login()" type="submit">Ingresar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="./index.js"></script>