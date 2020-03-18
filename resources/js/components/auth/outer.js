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
            this.user = user
        },
        getUser() {
            return this.user
        },

        guardarUser() {
            if (localStorage.getItem("user") != null) {
                this.setUser(JSON.parse(localStorage.getItem("user")));
            } else {
                console.log('else');
                axios.get('api/auth/user').then((res) => {
                    if (res.data.estado == 'success') {
                        this.setUser(res.data.user);
                        localStorage.setItem("user", JSON.stringify(this.user));
                    }
                });
            }

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