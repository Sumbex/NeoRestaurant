import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            id: this.$route.params.id,
            mesa: [],
            mesas: [],
            zonas: [],
            productos: [],
            pedidos: [],
            categoria: 0,
            categorias: [],
            idMesa: null,
            buscar: null,
            cantidad: 1,
            total: 0,
        }
    },
    methods: {
        seleccionarMesa(mesa) {
            this.mesa = mesa;
            console.log(this.mesa);
        },
        abrirCerrarMesa() {
            const data = {
                'mesa': this.mesa.id,
                'estado': this.mesa.estado_id,
            }
            axios.post('/api/abrir_cerrar_mesa', data).then((res) => {
                if (res.data.estado == 'success') {
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
                    this.traerMesas();
                } else {
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
        traerMesas() {
            axios.get('/api/traer_mesas_sucursal/' + this.id).then((res) => {
                if (res.data.estado == 'success') {
                    this.mesas = res.data.mesas;
                    this.zonas = res.data.zonas;
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
                    this.productos = [];
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
            let existe = false;
            for (let i = 0; i < this.pedidos.length; i++) {
                if (prod.id == this.pedidos[i].id_producto) {
                    this.pedidos[i].cantidad = this.pedidos[i].cantidad + 1;
                    this.pedidos[i].subtotal = this.pedidos[i].cantidad * this.pedidos[i].precio;
                    existe = true;
                    console.log('existe en la posicion: ' + i);
                    break;
                }
            }
            if (existe == false) {
                let subtotal = prod.precio_venta * this.cantidad;
                this.pedidos.push({ 'id_producto': prod.id, 'producto': prod.producto, 'cantidad': 1, 'precio': prod.precio_venta, 'subtotal': subtotal });
                this.totalPedido();
                console.log(this.pedidos);
            } else {
                this.totalPedido();
            }
        },
        totalPedido() {
            this.total = 0;
            for (let i = 0; i < this.pedidos.length; i++) {
                this.total = this.total + this.pedidos[i].subtotal;
            }
        },
        toggle() {
            $("#wrapper").toggleClass("toggled");
        },
    },
    mounted() {
        this.traerMesas();
        this.traerProductos();
        this.traerCategorias();
        this.toggle();
    }
};