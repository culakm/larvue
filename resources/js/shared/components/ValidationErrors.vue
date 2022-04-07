<template>
    <div>
        <!-- errorova hlaska ak mame nejake nedostatky ohladom hodnoty formularoveho prvku content -->
        <!-- toto musi byt na tej istej urovni ako textarea ktoru kontroluje, nemoze to byt vnorene v dalsom div -->
        <!-- tuto to je vnorene co je osetrene v <style></style> nizsie-->
        <div 
            class="invalid-feedback" 
            v-for="(error, index) in errors" 
            v-bind:key="key(index)">
            {{ error }}
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "errors"
    ],
    methods: {
        // funkcia na vygenerovanie nahodneho parametru key vyssie
        key(index) {
            return `validation_error_${index}_${Math.random()}`;
        }
    }
}
</script>

<style scoped>
/* .form-control.is-invalid - najdi element ktory ma class form-control a is-invalid
    ~                       - najdi jeho surodenca (element na rovnakej urovni
    > .invalid-feedback     - najdi v nom element ktory ma class invalid-feedback
*/
    .form-control.is-invalid ~ div > .invalid-feedback {
        display: block;
    }
</style>