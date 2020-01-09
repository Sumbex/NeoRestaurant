export default {
    methods: {
        logout: function () {
            this.$auth.logout({
                makeRequest: true,
                redirect: '/'
            });
        },

        toggle (){
            /* $("#menu-toggle").click(function (e) {
                e.preventDefault(); */
                $("#wrapper").toggleClass("toggled");
            /* }); */
        }
    }
};