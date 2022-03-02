// je zodpovedny za vsetky objekty s ktorymi pracujeme

<template>
    <div>
        <bookable-list-item item-title="Prvy Nazov" content="prvy obsah" v-bind:price="100"></bookable-list-item>
        <bookable-list-item item-title="Druhy Nazov" content="druhy obsah" v-bind:price="258"></bookable-list-item>
        <bookable-list-item></bookable-list-item>
        <bookable-list-item></bookable-list-item>
    </div>
</template>

<script>
import BookableListItem from "./BookableListItem";
export default {
    components: {
        BookableListItem
    },
    beforeCreate() {
        console.log('beforeCreate time')
    },
    created() {
        console.log('created time')
    },
    beforeMount() {
        console.log('beforeMount time')
    },
    mounted() {
        console.log('mounted time')
    },
    beforeDestroy() {
        console.log('beforeDestroy time')
    },
    destroyed() {
        console.log('destroyed time')
    }
}
</script>