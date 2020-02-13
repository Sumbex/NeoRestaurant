import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            checkAlmacen: [],
            almacenes: [],
            insumo: [],
            insumos: [],
            carro: [],
            activo: true,
        }
    },
    methods: {
        traerAlmacenes() {
            axios.get('api/traer_almacenes').then((res) => {
                if (res.data.estado == 'success') {
                    this.almacenes = res.data.almacenes;
                    for (let i = 0; i < this.almacenes.length; i++) {
                        this.checkAlmacen.push(this.almacenes[i].id);
                    }
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
        traerInsumos() {
            axios.get('api/traer_insumos_compra').then((res) => {
                if (res.data.estado == 'success') {
                    this.insumos = res.data.insumos;
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
        seleccionarInsumo(insumo) {
            this.insumo = insumo;
            this.activo = false;
        },
        añadirCarro() {
            //verificar si existe un item sumar o actualizar este si no agrarlo
            this.carro.push(this.insumo);
            this.insumo = [];
            console.log(this.carro);
        },
    },
    mounted() {
        this.traerAlmacenes();
    }
};