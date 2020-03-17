import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            sucursal: 0,
            select_sucursal: null,
            rut: null,
            nombres: null,
            apellidos: null,
            direccion: null,
        }
    },
    methods: {
        traerSucursales() {
            axios.get('api/traer_sucursales_select').then((res) => {
                if (res.data.estado == 'success') {
                    this.select_sucursal = res.data.sucursales;
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
    },
    mounted() {
        this.traerSucursales();
    }
};