export default {
    data() {
        return {
            user: [],
        }
    },
    setUser(user) {
        this.user = user;
    },
    getUser() {
        return this.user;
    },
    guardarUser() {
        if (localStorage.getItem("user") != null) {
            this.setUser(JSON.parse(localStorage.getItem("user")));
            return this.getUser();
        }
    },

};