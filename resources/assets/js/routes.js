import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

export default new Router({
    routes: [

        {
            path: '/',
            name: 'dashboard',
            component: require('./views/Dashboard')
        },
        {
            path: '/administrar/categoria',
            name: 'administrarCategoria',
            component: require('./views/Categoria')
        }
    ]
})