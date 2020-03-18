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

        getUser() {
            if (localStorage.getItem("user") != null) {
                this.user = JSON.parse(localStorage.getItem("user"));
                return this.user;
            }
        },

        guardarUser() {
            axios.get('api/auth/user').then((res) => {
                if (res.data.estado == 'success') {
                    localStorage.setItem("user", JSON.stringify(res.data.user));
                }
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
    computed: {
        currentPage() {
            return this.$route.path;
        }
    },
    mounted() {
        this.guardarUser();
    },
};