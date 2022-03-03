// zobrazi jeden konkretny objek z Bookables.
<template>
  <div class="card">
      <div class="card-body">
          <h1 class="card-title">{{ itemTitle }}</h1>
          <p class="card-text">{{ content }}</p>
          <p class="card-text">price: {{ price }}</p>
      </div>
  </div>
</template>

<script>
export default {
    //props: ["itemTitle","content","price"] // bez datovych typov ako pole
    props: { "itemTitle": String,"content": String,"price": Number }, // s datovymi typmi ako objekt
    mounted() {
        //console.log(this.itemTitle)
        // toto nastavi title hocijakej instancie ale pokial sa zmenia reactive data tak sa to prepise 
        //this.itemTitle = "pakovy title";
    }
}
</script>

<style>

</style>