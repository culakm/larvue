// zobrazi jeden konkretny objek z Bookables.
<template>
  <div>
      <h1>{{ itemTitle }}</h1>
      <p>{{ content }}</p>
  </div>
</template>

<script>
export default {
    //props: ["itemTitle","content","price"] // bez datovych typov ako pole
    props: { "itemTitle": String,"content": String,"price": Number }, // s datovymi typmi ako objekt
    mounted() { console.log(this.itemTitle) }
}
</script>

<style>

</style>