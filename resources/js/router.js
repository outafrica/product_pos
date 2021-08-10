import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

// Admin Pages
import adminproducts from './components/pages/admin/products'
import adminusers from './components/pages/admin/users'
import adminexpenses from './components/pages/admin/expense'
import adminsales from './components/pages/admin/sales_report'

// Agent Pages
import agentproducts from './components/pages/agents/products'
import agentexpenses from './components/pages/agents/expense'
import agentsales from './components/pages/agents/sales'

const routes = [

    // admin paths
    {
        path: '/admin/products',
        component: adminproducts,
        name: 'adminproducts'
    },

    {
        path: '/admin/users',
        component: adminusers,
        name: 'adminusers'
    },

    {
        path: '/admin/expenses',
        component: adminexpenses,
        name: 'adminexpenses'
    },

    {
        path: '/admin/sales',
        component: adminsales,
        name: 'adminsales'

    },

    // agent paths
    {
        path: '/agent/products',
        component: agentproducts,
        name: 'agentproducts'
    },

    {
        path: '/agent/expenses',
        component: agentexpenses,
        name: 'agentexpenses'
    },

    {
        path: '/agent/sales',
        component: agentsales,
        name: 'agentsales'

    },

]

export default new Router({
    mode: 'history',
    routes
})