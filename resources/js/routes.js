import ExampleComponent from "./components/ExampleComponent";
import Example2Component from "./components/Example2Component";
import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        component: ExampleComponent,
        name: "homeroutename",
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