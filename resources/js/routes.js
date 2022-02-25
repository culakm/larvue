import ExampleComponent from "./components/ExampleComponent";
import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        component: ExampleComponent,
        name: "home",
    }
]

const router = new VueRouter({
    routes, // short for routes: routes, co znamena ze do parametru routes priradi nase pole routes ktore sme definovali vyssie
});


// objekt router je automaticky exportovany
export default router;