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
            estado: false,
            estadoMesa: null,
            pedidoMesas: [],
            updpedidoMesas: [],
            mesasDrop: [],
            datosPedido: [],
            mesasPedido: null,
            updPedido: false,
            mesasBorrar: [],
        }
    },
    methods: {
        seleccionarMesa(mesa) {
            this.mesa = mesa;
            switch (this.mesa.estado_id) {
                case 1:
                    this.estado = true;
                    this.estadoMesa = 2;
                    break;

                case 2:
                    this.estado = false;
                    break;
                case 3:
                    this.estado = true;
                    this.estadoMesa = 3;
                    this.traerPedidoMesa();
                    break;
                default:
                    this.estado = true;
                    this.estadoMesa = 3;
                    this.traerPedidoMesa();
            }
            console.log(this.mesa);
        },
        añadirMesa(estado, mesa, quitar) {
            if (quitar == true) {
                this.pedidos = [];
                this.datosPedido = [];
                this.mesasBorrar = [];
                this.total = 0;
            }
            if (estado == true) {
                this.pedidoMesas = [];
                if (quitar == true) {
                    this.updPedido = false;
                    this.pedidoMesas.push({ 'id': this.mesa.id, 'mesa': this.mesa.mesa });
                } else {
                    this.updPedido = true;
                    for (let i = 0; i < this.updpedidoMesas.length; i++) {
                        this.pedidoMesas.push({ 'id': this.updpedidoMesas[i].id, 'mesa': this.updpedidoMesas[i].mesa });
                    }
                }
            } else {
                let existe = false;
                for (let i = 0; i < this.pedidoMesas.length; i++) {
                    if (mesa.id == this.pedidoMesas[i].id) {
                        existe = true;
                        console.log('existe en la posicion: ' + i + ', existe: ' + existe);
                        break;
                    }
                }
                if (existe == true) {
                    this.$snotify.create({
                        body: 'La mesa que intentas agregar ya se encuentra seleccionada.',
                        config: {
                            timeout: 4000,
                            showProgressBar: true,
                            closeOnClick: true,
                            pauseOnHover: false,
                            position: SnotifyPosition.centerBottom,
                            type: SnotifyStyle.warning,
                        }
                    });
                } else {
                    this.pedidoMesas.push({ 'id': mesa.id, 'mesa': mesa.mesa });
                }

            }

            console.log(this.pedidoMesas);
        },
        quitarMesa(id) {
            if (this.mesa.id == id) {
                this.$snotify.create({
                    body: 'No puedes quitar la mesa seleccionada.',
                    config: {
                        timeout: 2000,
                        showProgressBar: true,
                        closeOnClick: true,
                        pauseOnHover: false,
                        position: SnotifyPosition.centerBottom,
                        type: SnotifyStyle.warning,
                    }
                });
            } else {
                for (let i = 0; i < this.pedidoMesas.length; i++) {
                    if (this.pedidoMesas[i].id == id) {
                        this.mesasBorrar.push(this.pedidoMesas[i]);
                        this.pedidoMesas.splice(i, 1);
                    }
                }
                console.log(this.mesasBorrar);
            }

        },
        abrirCerrarMesa() {
            if (this.mesa == '') {
                this.$snotify.create({
                    body: 'Debe seleccionar una mesa.',
                    config: {
                        timeout: 2000,
                        showProgressBar: true,
                        closeOnClick: true,
                        pauseOnHover: false,
                        position: SnotifyPosition.centerBottom,
                        type: SnotifyStyle.warning,
                    }
                });
            } else {
                const data = {
                    'mesa': this.mesa.id,
                    'estado': this.mesa.estado_id,
                }
                axios.post('/api/abrir_cerrar_mesa', data).then((res) => {
                    if (res.data.estado == 'success') {
                        if (this.mesa.estado_id == 2) {
                            this.estado = true;
                            this.estadoMesa = 2;
                        } else {
                            this.estado = false;
                        }
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
            }
        },
        guardarMesas(res) {
            this.mesasDrop = [];
            let mesas = res.mesas;
            let zonas = res.zonas;
            for (let i = 0; i < zonas.length; i++) {
                for (let q = 0; q < mesas[zonas[i]].length; q++) {
                    if (mesas[zonas[i]][q].estado_id == 2) {
                        this.mesasDrop.push({ 'id': mesas[zonas[i]][q].id, 'mesa': mesas[zonas[i]][q].mesa });
                    }
                }
            }
        },
        traerMesas() {
            axios.get('/api/traer_mesas_sucursal/' + this.id).then((res) => {
                if (res.data.estado == 'success') {
                    this.guardarMesas(res.data);
                    this.mesas = res.data.mesas;
                    console.log(this.mesas);
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
        toggle() {
            $("#wrapper").toggleClass("toggled");
        },
        ingresarModificarPedido() {
            let id = null;
            if (this.datosPedido == []) {
                id = null;
            } else {
                id = this.datosPedido.id;
            }
            //datosPedido.id
            const data = {
                'sucursal_id': this.id,
                'id': id,
                'mesas': this.pedidoMesas,
                'pedidos': this.pedidos,
                'total': this.total,
                'update': this.updPedido,
                'mesas_borrar': this.mesasBorrar,
            }
            axios.post('/api/ingresar_actualizar_pedido', data).then((res) => {
                if (res.data.estado == 'success') {
                    this.estadoMesa = 3;
                    document.getElementById('cerrarModalPedido').click();
                    if (id != null) {
                        this.traerPedidoMesa();
                    }
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
                    });
                    this.traerMesas();
                } else if (res.data.estado == 'failed_prod') {
                    this.$snotify.create({
                        body: res.data.mensaje,
                        config: {
                            timeout: 5000,
                            showProgressBar: true,
                            closeOnClick: true,
                            pauseOnHover: false,
                            position: SnotifyPosition.centerBottom,
                            type: SnotifyStyle.error,
                        }
                    });
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
        verificarStock(prod) {
            const data = {
                'sucursal': this.id,
                'producto': prod
            }
            axios.post('/api/verificar_stock_producto', data).then((res) => {
                if (res.data.estado == 'success') {
                    this.agregarProducto(prod);
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
        traerPedidoMesa() {
            axios.get('/api/traer_pedido_mesa/' + this.id + '/' + this.mesa.id).then((res) => {
                if (res.data.estado == 'success') {
                    this.pedidos = [];
                    this.datosPedido = res.data.datos;
                    this.mesasPedido = res.data.mesas;
                    this.updpedidoMesas = res.data.mesas_pedido;
                    for (let i = 0; i < res.data.pedido.length; i++) {
                        this.pedidos.push({ 'id': res.data.pedido[i].id, 'id_producto': res.data.pedido[i].producto_id, 'producto': res.data.pedido[i].producto, 'cantidad': res.data.pedido[i].cantidad, 'precio': res.data.pedido[i].precio_venta, 'subtotal': res.data.pedido[i].subtotal });
                    }
                    this.totalPedido();
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
        imprimir() {
            window.print();
        }
    },
    mounted() {
        this.traerMesas();
        this.traerProductos();
        this.traerCategorias();
        this.toggle();
    }
};