import usuario from "../servicios/usuario";

export default {
    data() {
        return {
            activeClass: 'active',
            user: [],
        }
    },
    methods: {
        logout: function() {
            localStorage.removeItem('user');
            this.$auth.logout({
                makeRequest: true,
                redirect: '/'
            });
        },
        setUser(user) {
            this.user = user;
        },
        guardarUser() {
            let data = usuario.guardarUser();
            this.user = data;

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
    computed: {
        currentPage() {
            return this.$route.path;
        }
    },
    mounted() {
        this.guardarUser();
    },
};