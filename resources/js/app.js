require('./bootstrap');

import Vue from "vue";
import VueRouter from "vue-router";
import router from "./routes";
import Index from "./Index.vue";
import moment from "moment";

// globalne registrovany komponent
import StarRating from "./shared/components/StarRating";
import FatalError from "./shared/components/FatalError";
import ValidationErrors from "./shared/components/ValidationErrors";

window.Vue = require('vue').default;

// o tychto komponentoch vie Vue cez routes - globalna registracia
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

// registracia globalnych filtrov
Vue.filter("fromNow", value => moment(value).fromNow());

// registracia globalnych komponentov
Vue.component("star-rating", StarRating);
Vue.component("fatal-error", FatalError);
Vue.component("validation-errors", ValidationErrors);

const app = new Vue({
    el: '#app',
    router, // znova je to skratka ako v router.js
    components: { // Vue vie o tychto komponentoch - lokalna registracia
        "index": Index
    }
});
