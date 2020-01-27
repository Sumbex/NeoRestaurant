import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {

    data() {
        return {
            sucursal: null,
            direccion: null,
            observacion: null,
            sucursales: [],
            tabla: false,
            guardar: false,
        }
    },
    methods: {

        isDisabled: () {

        },
        ingresar() {
            const data = {
                'sucursal': this.sucursal,
                'direccion': this.direccion,
                'observacion': this.observacion,
            }
            axios.post('api/ingresar_sucursal', data).then((res) => {
                this.guardar = true;
                if (res.data.estado == 'success') {
                    this.guardar = false;
                    this.limpiar();
                    this.$snotify.create({
                        body: res.data.mensaje,
                        config: {
                            timeout: 2000,
                            showProgressBar: true,
                            closeOnClick: true,
                            pauseOnHover: false,
                            position: SnotifyPosition.centerBottom,
                            type: SnotifyStyle.success,
                        }
                    })
                    this.traer();
                } else {
                    this.guardar = false;
                    this.$snotify.create({
                        body: res.data.mensaje,
                        config: {
                            timeout: 2000,
                            showProgressBar: true,
                            closeOnClick: true,
                            pauseOnHover: false,
                            position: SnotifyPosition.centerBottom,
                            type: SnotifyStyle.error,
                        }
                    });

                }
            });
        },
        traer() {
            axios.get('api/traer_sucursales').then((res) => {
                if (res.data.estado == 'success') {
                    this.sucursales = res.data.sucursales;
                    this.tabla = true;
                } else {
                    this.$snotify.create({
                        body: res.data.mensaje,
                        config: {
                            timeout: 3000,
                            showProgressBar: true,
                            closeOnClick: true,
                            pauseOnHover: false,
                            position: SnotifyPosition.centerBottom,
                            type: SnotifyStyle.error,
                        }
                    })
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