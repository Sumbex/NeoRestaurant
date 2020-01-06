import Index from './components/publico/index.vue';

const routes = [
    {
        path: '/',
        component: Index,
        name: 'Index',
        iconCls: 'el-icon-message',
        meta: { auth: false },

        children: [

        ]
    },
];

export default routes;