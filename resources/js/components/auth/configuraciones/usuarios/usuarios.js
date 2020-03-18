import { SnotifyPosition, SnotifyStyle } from 'vue-snotify';
import usuario from '../../../servicios/usuario';

export default {
    data() {
        return {
            sucursal: 0,
            select_sucursal: null,
            rol: 0,
            select_rol: null,
            rut: null,
            nombres: null,
            apellidos: null,
            direccion: null,
            correo: null,
            user: [],
            bloquear: false,
        }
    },
    methods: {
        setUsuario() {
            let datos = usuario.guardarUser();
            this.user = datos;
        },
        bloquearCampos() {
            if (this.user.rol != 1) {
                this.bloquear = true;
            }
        },
        traerSucursales() {
            axios.get('api/traer_sucursales_select').then((res) => {
                if (res.data.estado == 'success') {
                    this.select_sucursal = res.data.sucursales;
                    this.sucursal = this.user.sucursal;
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
        traerRoles() {
            axios.get('api/traer_roles').then((res) => {
                if (res.data.estado == 'success') {
                    this.select_rol = res.data.roles;
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
        this.setUsuario();
        this.bloquearCampos();
        this.traerSucursales();
        this.traerRoles();
    }
};