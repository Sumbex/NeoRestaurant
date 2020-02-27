import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            id: null,
            almacen: 0,
            almacenes: [],
            productos: [],
            detalles: [],
            foto: null,

        }
    },
    methods: {
        setFoto(foto) {
            this.foto = foto;
        },
        traerProductos() {
            axios.get('api/traer_productos/' + this.almacen).then((res) => {
                if (res.data.estado == 'success') {
                    this.productos = res.data.productos;
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
        traerDetalle(id) {
            this.id = id;
            axios.get('api/traer_detalle_producto/' + this.id).then((res) => {
                if (res.data.estado == 'success') {
                    this.detalles = res.data.detalle;

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
        traerAlmacenes() {
            axios.get('api/traer_almacenes').then((res) => {
                if (res.data.estado == 'success') {
                    this.almacenes = res.data.almacenes;
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
        /* this.traerProductos(); */
        this.traerAlmacenes();
    }
};