
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
 
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
 
Vue.use(VueSweetalert2);

require('./bootstrap');

window.Vue = require('vue');
Vue.component('menu-component', require('./components/MenuComponent.vue'));
import router from './routes';
const app = new Vue({
    el: '#app',
    router
});
