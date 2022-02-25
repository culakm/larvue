<template>
    <div>
        <!-- toto prida do vystupu linky -->
        <!-- cesty su definovane v app.js -->
        <nav class="navbar navbar-light bg-light border-bottom">

        <!-- linky su definovane na zaklade URL routy -->
        <!-- <router-link to="/">Home</router-link>
        <router-link to="/second">Second</router-link>  -->

        <!-- linky su definovane na zaklade mena routy -->
        <router-link class="navbar-brand mr-auto" v-bind:to="{name: 'homeroutename'}">Larvue</router-link> <!-- miesto v-bind:to="" staci pisat len :to="" -->
        <router-link class="btn" v-bind:to="{name: 'secondroutename'}">Second</router-link> 

        </nav>

        <!-- toto je zobrazenie linky ktoru prave volame - renderovanie toho co chceme-->
        <!-- zobrazuje to linku na ktoru sa klikne a ktora je volana v URL -->
        <div class="container mt-4 mb-4 pr-4 pl-4">
            <router-view></router-view>
        </div>
        
    </div>
</template>