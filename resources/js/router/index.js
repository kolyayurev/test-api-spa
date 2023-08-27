import { createWebHistory, createRouter } from 'vue-router'
const Layout = () => import('@/components/layouts/Main.vue')

const routes = [
    {
        path: "/",
        component: Layout,
        children: [
            {
                name: "dashboard",
                path: '/',
                component: import('@/components/pages/Dashboard.vue'),
                meta: {
                    title: `Dashboard`
                }
            },
            {
                name: "Requests",
                path: '/requests',
                component: import('@/components/pages/requests/Index.vue'),
                meta: {
                    title: `Requests`
                }
            },
            {
                name: "RequestsCreate",
                path: '/requests/create',
                component: import('@/components/pages/requests/Form.vue'),
                meta: {
                    title: `Requests Create`
                }
            }
        ]
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
})

export default router
