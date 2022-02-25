require('./bootstrap');

import Vue from "vue";
import VueRouter from "vue-router";
import router from "./routes";
import Index from "./Index.vue";

window.Vue = require('vue').default;

// o tychto komponentoch vie Vue cez routes
// Vue.component(
//     'example-component', 
//     require('./components/ExampleComponent.vue').default
// );

// Vue.component(
//     'example-2-component', 
//     require('./components/Example2Component.vue').default
// );

// v ramci kazdeho komponentu Vue.js budeme mat pristup k $router, $route
Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router, // znova je to skratka ako v router.js
    components: { // Vue vie o tychto komponentoch
        "index": Index
    }
});
