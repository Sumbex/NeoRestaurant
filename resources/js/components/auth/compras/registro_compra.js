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
            total: 0,
            comprobante: null,
            archivo: null,
            fecha: null,
            boton: false,
        }
    },
    methods: {
        onFileChange(e) {
            this.archivo = e.target.files || e.dataTransfer.files;
            console.log(this.archivo[0]);
        },
        limpiar() {
            this.comprobante = '';
            this.fecha = '';
            this.archivo = null;
            this.proveedor = 0;
        },
        ingresarInsumos() {
            if (this.checkAlmacen.length < 2) {
                let formData = new FormData();
                formData.append('carro', JSON.stringify(this.carro));
                formData.append('almacenes', this.checkAlmacen);
                formData.append('proveedor', this.proveedor);
                formData.append('total', this.total);
                formData.append('fecha', this.fecha);
                formData.append('comprobante', this.comprobante);
                formData.append('archivo', this.archivo[0]);

                axios.post('api/registrar_compra', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((res) => {
                    if (res.data.estado == 'success') {
                        this.limpiarCarro();
                        this.limpiar();
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
                        this.traerInsumos();
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
            } else {
                this.$snotify.create({
                    body: 'Solo puede registrar la compra de una sucursal individualmente.',
                    config: {
                        timeout: 3000,
                        showProgressBar: true,
                        closeOnClick: true,
                        pauseOnHover: false,
                        position: SnotifyPosition.centerBottom,
                        type: SnotifyStyle.warning,
                    }
                });
            }
        },
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
            insumo.cantidad = 1;
            this.insumo = insumo;
            this.activo = false;
            document.getElementById('cerrarModal').click();
        },
        añadirCarro() {
            let existe = false;
            let mod = false;
            for (let i = 0; i < this.carro.length; i++) {
                if (this.insumo.id == this.carro[i].insumo_id) {
                    existe = true;
                    console.log('existe en la posicion: ' + i + ', existe: ' + existe);
                    break;
                } else if (this.insumo.insumo_id == this.carro[i].insumo_id) {
                    this.eliminarItem(i);
                    mod = true;
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
                let total = (this.insumo.cantidad * this.insumo.precio);
                if (mod == true) {
                    this.carro.push({ 'insumo_id': this.insumo.insumo_id, 'insumo': this.insumo.insumo, 'unidad_id': this.insumo.unidad_id, 'cantidad': this.insumo.cantidad, 'precio': this.insumo.precio, 'total': total });
                    this.boton = false;
                } else {
                    this.carro.push({ 'insumo_id': this.insumo.id, 'insumo': this.insumo.insumo, 'unidad_id': this.insumo.unidad_id, 'cantidad': this.insumo.cantidad, 'precio': this.insumo.precio, 'total': total });
                }
                this.total = 0;
                for (let i = 0; i < this.carro.length; i++) {
                    this.total = this.total + this.carro[i].total;
                }
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
                    this.total = this.total + this.carro[i].total;
                }
            }

        },
        eliminarItem(indice) {
            this.carro.splice(indice, 1);
            this.total = 0;
            for (let i = 0; i < this.carro.length; i++) {
                this.total = this.total + this.carro[i].total;
            }
            localStorage.removeItem('carro');
            localStorage.setItem("carro", JSON.stringify(this.carro));

        },
        modificarItem(indice) {
            this.insumo = this.carro[indice];
            /* console.log(this.insumo); */
            this.activo = false;
            this.boton = true;

            this.carro[indice].cantidad = this.insumo.cantidad;
            localStorage.removeItem('carro');
            localStorage.setItem("carro", JSON.stringify(this.carro));


        },
        limpiarCarro() {
            localStorage.removeItem('carro');
            this.carro = [];
            this.total = 0;
        }

    },
    mounted() {
        this.traerAlmacenes();
        this.cargarCarro();
        this.traerProveedores();
    }
};