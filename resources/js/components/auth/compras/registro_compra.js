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
            cantidad: null,
            proveedor: 0,
            prove_select: [],
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
        traerProveedores() {
            axios.get('api/traer_proveedores_select').then((res) => {
                if (res.data.estado == 'success') {
                    this.prove_select = res.data.proveedores;
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
            this.cantidad = 1;
            this.insumo = insumo;
            this.activo = false;
            document.getElementById('cerrarModal').click();
        },
        añadirCarro() {
            let existe = false;
            for (let i = 0; i < this.carro.length; i++) {
                if (this.insumo.id == this.carro[i].insumo_id) {
                    existe = true;
                    console.log('existe en la posicion: ' + i + ', existe: ' + existe);
                    break;
                }
            }
            if (existe == true) {
                this.insumo = [];
                this.activo = true;
                this.cantidad = null;
                this.$snotify.create({
                    body: 'El insumo que has seleccionado ya se encuentra agregado.',
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
                let total = (this.cantidad * this.insumo.precio);
                this.carro.push({ 'insumo_id': this.insumo.id, 'insumo': this.insumo.insumo, 'unidad_id': this.insumo.unidad_id, 'cantidad': this.cantidad, 'precio': this.insumo.precio, 'total': total });
                localStorage.setItem("carro", JSON.stringify(this.carro));
                this.insumo = [];
                this.activo = true;
                this.cantidad = null;

            }
        },
        cargarCarro() {
            if (localStorage.getItem("carro") != null) {
                let carroGuardado = JSON.parse(localStorage.getItem("carro"));
                for (let i = 0; i < carroGuardado.length; i++) {
                    this.carro.push(carroGuardado[i]);
                }
            }

        },
        eliminarItem(indice) {
            this.carro.splice(indice, 1);
            localStorage.removeItem('carro');
            localStorage.setItem("carro", JSON.stringify(this.carro));
        },
        modificarItem(item) {
            console.log(item);
            this.cantidad = 1;
            this.insumo = item;
            this.activo = false;
        },
        limpiarCarro() {
            localStorage.removeItem('carro');
            this.carro = [];
        }

    },
    mounted() {
        this.traerAlmacenes();
        this.cargarCarro();
        this.traerProveedores();
    }
};