import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            id: null,
            almacen: 0,
            almacenes: [],
            anio: 0,
            anios: [],
            mes: 0,
            meses: [],
            compras: [],
            detalles: [],
            total: null,

        }
    },
    methods: {
        traerCompras() {
            if (this.anio != 0 && this.mes != 0 && this.almacen != 0) {
                axios.get('api/traer_compras/' + this.anio + '/' + this.mes + '/' + this.almacen).then((res) => {
                    if (res.data.estado == 'success') {
                        this.compras = res.data.compras;
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
        traerDetalle(id) {
            this.id = id;
            axios.get('api/traer_detalle_compra/' + this.id).then((res) => {
                if (res.data.estado == 'success') {
                    this.detalles = res.data.detalles;
                    this.total = res.data.total;
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
        traerAnios() {
            axios.get('api/traer_anios').then((res) => {
                if (res.data.estado == 'success') {
                    this.anios = res.data.anios;
                }
            });
        },
        traerMeses() {
            axios.get('api/traer_meses').then((res) => {
                if (res.data.estado == 'success') {
                    this.meses = res.data.meses;
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
        this.traerAnios();
        this.traerMeses();
        this.traerAlmacenes();
    }
};