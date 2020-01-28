export default {
    data() {
        return {
            activeClass: 'active',
        }
    },
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
    },
    computed:{
        currentPage(){
            return this.$route.path;
        }   
    }
};