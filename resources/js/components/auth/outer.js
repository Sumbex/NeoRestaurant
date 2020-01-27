export default {
    methods: {
        logout: function() {
            this.$auth.logout({
                makeRequest: true,
                redirect: '/'
            });
        },

        toggle() {
            $("#wrapper").toggleClass("toggled");
        },

        url(ruta) {
            this.$router.push({ name: ruta }).catch(error => {
                if (error.name != "NavigationDuplicated") {
                    throw error;
                }
            });
        }
    }
};