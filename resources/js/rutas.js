import Index from './components/publico/index.vue';

import Auth from './components/auth/outer.vue';
import Home from './components/auth/home/home.vue';

const routes = [
    {
        path: '/',
        component: Index,
        name: 'Index',
        iconCls: 'el-icon-message',
        meta: { auth: false },
    },
    {
        path: '/home',
        component: Auth,
        name: 'Administration',
/*         redirect: 'index', */
        iconCls: 'el-icon-message',
        meta: { auth: true },
        children: [

            { path: '/home', component: Home, name: 'Home' },

        ]
    }
];

export default routes;