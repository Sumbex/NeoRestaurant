export default {
    data() {
        return {
            sucursal: null,
            direccion: null,
            observacion: null,
            sucursales: []
        }
    },
    methods: {
        ingresar() {
            const data = {
                'sucursal': this.sucursal,
                'direccion': this.direccion,
                'observacion': this.observacion,
            }
            axios.post('api/ingresar_sucursal', data).then((res) => {
                if (res.data.estado = 'success') {
                    this.limpiar();
                    this.$notify({
                        group: 'foo',
                        title: '<h4>Nothing!</h4>',
                        text: 'Don`t eat it!',
                        type: 'warning',
                        duration: -10
                      })
                    this.traer();
                } else {
                    alert(res.data.mensaje);
                }
            });
        },
        traer() {
            axios.get('api/traer_sucursales').then((res) => {
                if (res.data.estado = 'success') {
                    this.sucursales = res.data.sucursales;
                    console.log(this.sucursales);
                } else {
                    alert(res.data.mensaje);
                }
            });
        },
        limpiar() {
            this.sucursal = '';
            this.direccion = '';
            this.observacion = '';
        }
    },
    mounted() {
        this.traer();
    }
};