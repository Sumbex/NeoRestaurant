import Public from './components/publico/outer.vue';
import Index from './components/publico/index.vue';

import NotFound from './components/404.vue';

import Auth from './components/auth/outer.vue';
import Home from './components/auth/home/home.vue';
import Sucursal from './components/auth/sucursal/sucursal.vue';
import Mesas from './components/auth/sucursal/mesas/mesas.vue';

import POS from './components/auth/pos/pos.vue';
import POSMesas from './components/auth/pos/mesas/ver_mesas.vue';

import Insumos from './components/auth/insumos/insumos.vue';
import CompraInsumos from './components/auth/compras/registro_compra.vue';
import VerCompraInsumos from './components/auth/compras/ver_compras/ver_compras.vue';

import Provedores from './components/auth/provedor/proveedor.vue';

import Productos from './components/auth/productos/producto.vue';

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
            {
                name: 'POS',
                path: 'pos',
                component: POS
            },
            {
                name: 'POSMesas',
                path: '/pos/mesas/:id',
                component: POSMesas
            },
            {
                name: 'Insumos',
                path: '/insumos',
                component: Insumos
            },
            {
                name: 'RegistroInsumo',
                path: '/registro-compra',
                component: CompraInsumos
            },
            {
                name: 'VerCompraInsumos',
                path: '/ver-compras',
                component: VerCompraInsumos
            },
            {
                name: 'Provedores',
                path: '/provedores',
                component: Provedores
            },
            {
                name: 'Productos',
                path: '/productos',
                component: Productos
            }
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