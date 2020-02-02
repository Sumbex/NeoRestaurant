import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            categoria: null,
            categorias: [],
            insumo: null,
            insumos: [],
            unidad: 0,
            unidadSelect: [],
            catInsumo: 0,
            catInsumoSelect: [],
            medida: 0,
            medidaSelect: [],
            cantidad: null,
            stock: null,
            precio: null,
        }
    },
    methods: {
        limpiar() {
            this.insumo = '';
            this.unidad = 0;
            this.catInsumo = 0;
            this.medida = 0;
            this.cantidad = '';
            this.stock = '';
            this.precio = '';
        },
        ingresarInsumos() {
            const data = {
                'insumo': this.insumo,
                'unidad': this.unidad,
                'categoria': this.catInsumo,
                'medida': this.medida,
                'cantidad': this.cantidad,
                'stock': this.stock,
                'precio': this.precio,
            }
            axios.post('api/ingresar_insumo', data).then((res) => {
                if (res.data.estado == 'success') {
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
        traerInsumos() {
            axios.get('api/traer_insumos').then((res) => {
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
        ingresarCategorias() {
            const data = {
                'categoria': this.categoria
            }
            axios.post('api/ingresar_categoria_insumo', data).then((res) => {
                if (res.data.estado == 'success') {
                    this.categoria = '';
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
            axios.get('api/traer_categoria_insumos').then((res) => {
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
            axios.get('api/traer_categoria_insumos_select').then((res) => {
                if (res.data.estado == 'success') {
                    this.catInsumoSelect = res.data.categorias;
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
        this.traerCategoriasSelect();
        this.traerInsumos();
    }
};