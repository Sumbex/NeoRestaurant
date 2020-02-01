import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            categoria: null,
            categorias: [],
            insumo: null,
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
                    /* this.traerZonaSelect() */
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
            axios.get('/api/traer_categoria_insumos/').then((res) => {
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
    },
    mounted() {
        /* this.traerMesas(); */
    }
};