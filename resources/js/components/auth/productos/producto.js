import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            checkAlmacen: [],
            almacenes: [],
            insumo: [],
            insumos: [],
            cateDesc: null,
            categorias: [],
            categoria: 0,
            categoria_select: [],
            destino: 0,
            destino_select: [],
            carro: [],
            activo: true,
            producto: null,
            precio: null,
            archivo: null,
            boton: false,
        }
    },
    methods: {
        onFileChange(e) {
            this.archivo = e.target.files || e.dataTransfer.files;
            console.log(this.archivo[0]);
        },
        ingresarCategorias() {
            const data = {
                'categoria': this.cateDesc
            }
            axios.post('api/ingresar_categoria_productos', data).then((res) => {
                if (res.data.estado == 'success') {
                    this.cateDesc = '';
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
                    this.traerCategorias();
                    this.traerCategoriasSelect();
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
        traerCategorias() {
            axios.get('api/traer_categoria_productos').then((res) => {
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
        traerCategoriasSelect() {
            axios.get('api/traer_categoria_productos_select').then((res) => {
                if (res.data.estado == 'success') {
                    this.categoria_select = res.data.categorias;
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
                if (mod == true) {
                    this.carro.push({ 'insumo_id': this.insumo.insumo_id, 'insumo': this.insumo.insumo, 'unidad_id': this.insumo.unidad_id, 'cantidad': this.insumo.cantidad });
                    this.boton = false;
                } else {
                    this.carro.push({ 'insumo_id': this.insumo.id, 'insumo': this.insumo.insumo, 'unidad_id': this.insumo.unidad_id, 'cantidad': this.insumo.cantidad });
                }
                localStorage.setItem("carro_producto", JSON.stringify(this.carro));
                this.insumo = [];
                this.activo = true;
                this.cantidad = null;

            }
        },
        cargarCarro() {
            if (localStorage.getItem("carro_producto") != null) {
                let carroGuardado = JSON.parse(localStorage.getItem("carro_producto"));
                for (let i = 0; i < carroGuardado.length; i++) {
                    this.carro.push(carroGuardado[i]);
                }
            }

        },
        eliminarItem(indice) {
            this.carro.splice(indice, 1);
            localStorage.removeItem('carro_producto');
            localStorage.setItem("carro_producto", JSON.stringify(this.carro));

        },
        modificarItem(indice) {
            this.insumo = this.carro[indice];
            this.activo = false;
            this.boton = true;

            this.carro[indice].cantidad = this.insumo.cantidad;
            localStorage.removeItem('carro_producto');
            localStorage.setItem("carro_producto", JSON.stringify(this.carro));


        },
        limpiarCarro() {
            localStorage.removeItem('carro_producto');
            this.carro = [];
        },
        limpiar() {
            this.producto = '';
            this.categoria = 0;
            this.destino = 0;
            this.archivo = null;
            this.precio = null;
        },
        ingresarProducto() {
            let formData = new FormData();
            formData.append('almacenes', this.checkAlmacen);
            formData.append('carro', JSON.stringify(this.carro));
            formData.append('producto', this.producto);
            formData.append('categoria', this.categoria);
            formData.append('destino', this.destino);
            formData.append('archivo', this.archivo[0]);
            formData.append('precio', this.precio);
            axios.post('api/ingresar_producto', formData, {
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
        },
    },
    mounted() {
        this.traerCategoriasSelect();
        this.traerAlmacenes();
        this.cargarCarro();

    }
};