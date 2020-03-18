import usuario from "../servicios/usuario";

export default {

    data() {
        return {
            rut: "",
            password: "",
        };
    },

    methods: {
        login() {
            var app = this;
            this.$auth.login({
                params: {
                    rut: app.rut,
                    password: app.password
                },
                success: function() {
                    let datos = this.$auth.user();
                    localStorage.setItem("user", JSON.stringify(datos));
                },
                error: function() {},
                rememberMe: true,
                redirect: "/home",
                fetchUser: true
            });
        },
    }
};