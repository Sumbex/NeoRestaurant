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
                success: function () { },
                error: function () { },
                rememberMe: true,
                redirect: "/home",
                fetchUser: true
            });
        },
    }
};