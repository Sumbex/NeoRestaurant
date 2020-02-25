import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            sucursal: 0,
            sucursal_select: [],
            nombre: null,
            cajas: [],
            guardar: true,
        }
    },
    methods: {
        limpiar() {
            this.sucursal = 0;
            this.nombre = '';
        },
        ingresarCaja() {
            const data = {
                'id': this.sucursal,
                'caja': this.nombre,
            }
            axios.post('api/ingresar_caja', data).then((res) => {
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
                    this.traerCajas();
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
        traerCajas() {
            axios.get('api/traer_cajas').then((res) => {
                if (res.data.estado == 'success') {
                    this.cajas = res.data.cajas;
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
        traerSucursales() {
            //
            axios.get('api/traer_sucursales_select').then((res) => {
                if (res.data.estado == 'success') {
                    this.sucursal_select = res.data.sucursales;
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
        }
    },
    mounted() {
        this.traerCajas();
        this.traerSucursales();
    }
};