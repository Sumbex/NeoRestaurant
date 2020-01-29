import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            sucursal: 0,
            select_sucursal: null,
            zonas: null,
            select_zonas: null,
            radio: true,
            disabled: true,
            tabla: false,
            /* checkmul: false, */
        }
    },
    methods: {
        estado() {
            if (this.radio == true) {
                this.disabled = true;
            } else {
                this.disabled = false;
            }
        },
        traerSucursales() {
            axios.get('api/traer_sucursales_select').then((res) => {
                if (res.data.estado == 'success') {
                    this.select_sucursal = res.data.sucursales;
                    this.tabla = true;
                } else {
                    this.tabla = true;
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
        traerZonaSelect() {
            axios.get('api/traer_zonas_select').then((res) => {
                if (res.data.estado == 'success') {
                    this.select_zonas = res.data.zonas;
                    this.tabla = true;
                } else {
                    this.tabla = true;
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
        this.traerSucursales();
        this.traerZonaSelect();
    },

};