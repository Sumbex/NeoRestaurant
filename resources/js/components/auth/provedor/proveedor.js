import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';

export default {
    data() {
        return {
            rut: null,
            razon: null,
            direccion: null,
            pagina: null,
            contacto: null,
            fono: null,
            correo: null,
            proveedores: [],
        }
    },
    methods: {
        limpiar() {
            this.rut = '';
            this.razon = '';
            this.direccion = '';
            this.pagina = '';
            this.contacto = '';
            this.fono = '';
            this.correo = '';
        },
        ingresarProveedor() {
            const data = {
                'rut': this.rut,
                'razon': this.razon,
                'direccion': this.direccion,
                'pagina': this.pagina,
                'contacto': this.contacto,
                'fono': this.fono,
                'correo': this.correo,
            }
            axios.post('api/ingresar_proveedor', data).then((res) => {
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
                    this.traerProveedores();
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
        traerProveedores() {
            axios.get('api/traer_proveedores').then((res) => {
                if (res.data.estado == 'success') {
                    this.proveedores = res.data.proveedores;
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
        this.traerProveedores();
    }
};