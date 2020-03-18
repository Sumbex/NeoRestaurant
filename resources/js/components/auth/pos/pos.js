import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            sucursales: [],
            /* sucursal: '',
            direccion: '',
            observacion: '',
            sucursales: [],
            tabla: false,
            guardar: false,
            boton: true,
            errors: [], */
        }
    },
    methods: {

        url(id) {
            this.$router.push({
                name: 'POSMesas',
                params: id,
            }).catch(error => {
                if (error.name != "NavigationDuplicated") {
                    throw error;
                }
            });
        },
        traer() {
            axios.get('api/traer_sucursales').then((res) => {
                if (res.data.estado == 'success') {
                    this.sucursales = res.data.sucursales;
                    /* this.tabla = true; */
                } else {
                    /* this.tabla = true; */
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
        redirigir() {
            let user = JSON.parse(localStorage.getItem("user"));
            if (user.rol != 1) {
                this.url({
                    id: user.sucursal
                });
            } else {
                this.traer();
            }
        }
    },
    mounted() {
        this.redirigir();
    },

};