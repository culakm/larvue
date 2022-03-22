<!-- zobrazi jeden konkretny objekt z Bookables. -->
<template>
    <!-- w-100 je zodpovedne za maximalne roztiahnutie na sirku nadriadeneho elementu -->
    <div class="card w-100">
        <div class="card-body">
            <!-- linka, to = meno routy, params = parametre z dat bookable objektu -->
            <router-link :to="{name: 'bookable', params: {id: id}}">
                <h1 class="card-title">{{ itemTitle }}</h1>\
            </router-link>
            <p class="card-text">{{ content }}</p>
            <p class="card-text">id: {{ id }}</p>
        </div>
    </div>
</template>

<script>
export default {
    //props: ["itemTitle","content","price"] // bez datovych typov ako pole
    props: { "itemTitle": String,"content": String,"id": Number }, // s datovymi typmi ako objekt
    mounted() {
        //console.log(this.itemTitle)
        // toto nastavi title hocijakej instancie ale pokial sa zmenia reactive data tak sa to prepise 
        //this.itemTitle = "pakovy title";
    }
}
</script>

<style>
</style>