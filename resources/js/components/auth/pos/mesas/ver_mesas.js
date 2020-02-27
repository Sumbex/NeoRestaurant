import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            id: this.$route.params.id,
            mesas: [],
            zonas: [],
            productos: [],
            pedido: [],
            categoria: 0,
            categorias: [],
            idMesa: null,
            buscar: null,
        }
    },
    methods: {
        traerMesas() {
            axios.get('/api/traer_mesas_sucursal/' + this.id).then((res) => {
                if (res.data.estado == 'success') {
                    this.mesas = res.data.mesas;
                    this.zonas = res.data.zonas;
                    console.log(this.mesas);
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
        traerProductos() {
            axios.get('/api/traer_productos_pedidos/' + this.id + '/' + this.categoria).then((res) => {
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
        traerCategorias() {
            axios.get('/api/traer_categoria_productos_select/').then((res) => {
                if (res.data.estado == 'success') {
                    this.categorias = res.data.categorias;
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
        agregarProducto(prod) {
            /* this.carro.push({ 'insumo_id': this.insumo.insumo_id, 'insumo': this.insumo.insumo, 'unidad_id': this.insumo.unidad_id, 'cantidad': this.insumo.cantidad }); */

            this.pedido.push();
        }
    },
    mounted() {
        this.traerMesas();
        this.traerProductos();
        this.traerCategorias();
    }
};