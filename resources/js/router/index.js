
const routes = [
    {
        path: '/admin/dashboard',
        name: 'dashboard',
        component: () => import('../views/admin/Dashboard.vue')
     },
     {
        path: '/admin/user',
        name: 'user',
        component: () => import('../views/admin/users/Index.vue')
     },
     {
        path: '/admin/profile',
        name: 'profile',
        component: () => import('../views/admin/profile/Index.vue')
     },
     {
        path: '/admin/invoice',
        name: 'invoice',
        component: () => import('../views/admin/InvoiceComponent.vue')
     },

     {
        path: '*',
        component: () => import('../components/NotFound.vue')
     },

  ]

  export default routes;
