<template>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <br />
      <h1 class="text-center">Neo RestoBar</h1>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center">Identifiquese</h5>
          <form>
            <div class="form-label-group">
              <input
                type="email"
                class="form-control"
                placeholder="Ingrese su correo"
                required
                autofocus
              />
              <label for="inputEmail">Correo</label>
            </div>

            <div class="form-label-group">
              <input
                type="password"
                class="form-control"
                placeholder="Ingrese su contraseña"
                required
              />
              <label for="inputPassword">Contraseña</label>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>