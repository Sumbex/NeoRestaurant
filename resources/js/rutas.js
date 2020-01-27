import Public from './components/publico/outer.vue';
import Index from './components/publico/index.vue';

import NotFound from './components/404.vue';

import Auth from './components/auth/outer.vue';
import Home from './components/auth/home/home.vue';
import Sucursal from './components/auth/sucursal/sucursal.vue';
import Mesas from './components/auth/sucursal/mesas/mesas.vue';
/* 
const routes = [{
        path: '/',
        component: Public,
        name: 'Public',
        redirect: 'index',
        iconCls: 'el-icon-message',
        meta: { auth: false },

        children: [{
                name: 'index',
                path: '/',
                component: Index
            },

        ]
    },

    {
        path: '/',
        component: Auth,
        name: 'Auth',
        redirect: 'Home',
        iconCls: 'el-icon-message',
        meta: { auth: true },

        children: [{
                name: 'Home',
                path: '/home',
                component: Home
            },
            {
                name: 'Sucursal',
                path: '/sucursales',
                component: Sucursal
            },
            {
                name: 'Mesas',
                path: '/mesas',
                component: Mesas
            },

        ]
    },

    {
        path: '/404',
        component: NotFound,
        name: '',
        hidden: true
    },

    {
        path: '*',
        hidden: true,
        redirect: { path: '/' }
    }

]; */
const routes = [{
        path: '/',
        component: Index,
        name: 'Index',
        iconCls: 'el-icon-message',
        meta: { auth: false },
    },
    {
        path: '/',
        component: Auth,
        name: 'Auth',
        redirect: 'Home',
        iconCls: 'el-icon-message',
        meta: { auth: true },

        children: [{
                name: 'Home',
                path: '/home',
                component: Home
            },
            {
                name: 'Sucursal',
                path: '/sucursales',
                component: Sucursal
            },
            {
                name: 'Mesas',
                path: '/mesas',
                component: Mesas
            },

        ]
    },
    {
        path: '/404',
        component: NotFound,
        name: '',
        hidden: true
    },

];



export default routes;