import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            id: this.$route.params.id,
            mesas: [],
            zonas: [],
            idMesa: null,
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
    },
    mounted() {
        this.traerMesas();
    }
};