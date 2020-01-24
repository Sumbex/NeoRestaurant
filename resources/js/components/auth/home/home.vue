<template>
  <div class="row justify-center my-3">
    <div class="col-sm-3">
      <div class="card text-white bg-primary sm-3 my-3">
        <div class="row px-2 no-gutters">
          <div class="col-6 ml-4 mt-2">
            <h3 class="card-title">0</h3>
            <label>Compras</label>
          </div>
          <div class="col-4 mt-3">
            <i class="fas fa-truck fa-3x"></i>
          </div>
        </div>
        <div class="card-footer text-center">
          Mas información
          <i class="fas fa-arrow-alt-circle-right"></i>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card text-white bg-success sm-3 my-3">
        <div class="row px-2 no-gutters">
          <div class="col-6 ml-4 mt-2">
            <h3 class="card-title">0</h3>
            <label>Ventas</label>
          </div>
          <div class="col-4 mt-3">
            <i class="fas fa-chart-line fa-3x"></i>
          </div>
        </div>
        <div class="card-footer text-center">
          Mas información
          <i class="fas fa-arrow-alt-circle-right"></i>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card text-white bg-warning sm-3 my-3">
        <div class="row px-2 no-gutters">
          <div class="col-6 ml-4 mt-2">
            <h3 class="card-title">0</h3>
            <label>Productos</label>
          </div>
          <div class="col-4 mt-3">
            <i class="fas fa-shopping-bag fa-3x"></i>
          </div>
        </div>
        <div class="card-footer text-center">
          Mas información
          <i class="fas fa-arrow-alt-circle-right"></i>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card text-white bg-danger sm-3 my-3">
        <div class="row px-2 no-gutters">
          <div class="col-6 ml-4 mt-2">
            <h3 class="card-title">0</h3>
            <label>Stock Minimo</label>
          </div>
          <div class="col-4 mt-3">
            <i class="fas fa-exclamation-circle fa-3x"></i>
          </div>
        </div>
        <div class="card-footer text-center">
          Mas información
          <i class="fas fa-arrow-alt-circle-right"></i>
        </div>
      </div>
    </div>

    <div class="col-sm-12">
      <canvas ref="chart" width="300" height="100"></canvas>
    </div>
  </div>
</template>

<script>
import Chart from "chart.js";

export default {
  name: "app",
  mounted() {
    var chart = this.$refs.chart;
    var ctx = chart.getContext("2d");
    var myChart = new Chart(ctx, {
      type: "line",
      data: {
        labels: [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio" /* , "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" */
        ],
        datasets: [
          {
            label: "Ventas Anuales",
            data: [50.0, 100.0, 70.0, 200.0, 110.0, 350.0, 250.0],
            backgroundColor: [
              "rgba(255, 99, 132, 0.2)",
              "rgba(54, 162, 235, 0.2)",
              "rgba(255, 206, 86, 0.2)",
              "rgba(75, 192, 192, 0.2)",
              "rgba(153, 102, 255, 0.2)",
              "rgba(255, 159, 64, 0.2)"
            ],
            borderColor: [
              "rgba(255,99,132,1)",
              "rgba(54, 162, 235, 1)",
              "rgba(255, 206, 86, 1)",
              "rgba(75, 192, 192, 1)",
              "rgba(153, 102, 255, 1)",
              "rgba(255, 159, 64, 1)"
            ],
            borderWidth: 1
          }
        ]
      },
      options: {
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true
              }
            }
          ]
        },
        onClick: event => {
          var activePoints = myChart.getElementsAtEventForMode(
            event,
            "point",
            myChart.options
          );
          if (activePoints.length > 0) {
            var firstPoint = activePoints[0];
            var label = myChart.data.labels[firstPoint._index];
            var value =
              myChart.data.datasets[firstPoint._datasetIndex].data[
                firstPoint._index
              ];
            alert(label + ": " + value);
          }
        }
      }
    });
  }
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
#content {
  margin: auto;
  width: 1024px;
  background-color: #ffffff;
  padding: 20px;
}
</style>