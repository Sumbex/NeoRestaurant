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
              <input
                type="text"
                class="form-control"
                placeholder="Nombre Sucursal"
                aria-label="Nombre"
              />
            </div>
            <div class="form-group col-md-6">
              <input
                type="text"
                class="form-control"
                placeholder="Direccion"
                aria-label="Direccion"
              />
            </div>
            <div class="form-group col-md-12">
              <textarea class="form-control resize-none" placeholder="Observacion" aria-label="Observacion"></textarea>
            </div>
            <div class="form-group col-md-12 mt-2 mb-3 text-center">
              <button type="button" class="btn btn-success">Guardar</button>
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
  </div>
</template>

<style src="./sucursal.css"></style>