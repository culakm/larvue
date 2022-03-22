import Example2Component from "./components/Example2Component";
import Bookables from "./bookables/Bookables";
import Bookable from "./bookable/Bookable";
import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        component: Bookables,
        name: "home",
    },
    {
        path: "/bookable/:id",
        component: Bookable,
        name: "bookable",
    },
    {
        path: "/second",
        component: Example2Component,
        name: "secondroutename",
    }
]

const router = new VueRouter({
    routes, // short for routes: routes, co znamena ze do parametru routes priradi nase pole routes ktore sme definovali vyssie
    mode: "history",

});


// objekt router je automaticky exportovany
export default router;