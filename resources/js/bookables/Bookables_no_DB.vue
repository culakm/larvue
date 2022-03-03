// je zodpovedny za vsetky objekty s ktorymi pracujeme

<template>
    <div>
        <!-- columns je z data -->
        columns: {{ columns }}
        <!-- rows je z computed -->
        rows: {{ rows }}

        <!-- pole reactive -->
        <!-- uz je naloadovane? -->
        <div v-if="loading">
            Data is loading...
        </div>
        <div v-else>
            <!-- tabulkou rozdelene vykreslovanie -->
            <!-- key atribut je 'row1, row2 aby to nemalo rovnake mena ako jednotlive instancie v zozname -->
            <div class="row mb-4" v-for="row in rows" v-bind:key="'row' + row">
                <!-- column je zrejme automaticky dodavany index -->
                <div class="col" v-for="(bookable, column) in bookablesInRow(row)" v-bind:key="'row' + row + column">
                <bookable-list-item
                    v-bind:item-title="bookable.itemTitle"
                    v-bind:content="bookable.content"
                    v-bind:price="bookable.price"
                >
                </bookable-list-item>
                </div>
                <!-- drzace miesta pokial je pocet instancii na zobrazenie riadku mensi ako pocet, ktory sa ma v riadku zobrazit -->
                <div class="col" v-for="p in placeholdersInRow(row)" v-bind:key="'placeholder' + row + p"></div>
            </div>  

            <!-- postupne vykreslovanie pola -->
            <bookable-list-item
                v-for="(bookable, index)  in bookables" 
                v-bind:key="index"
                v-bind:item-title="bookable.itemTitle"
                v-bind:content="bookable.content"
                v-bind:price="bookable.price"
                >
            </bookable-list-item>
        </div>

        <!-- data natvrdo  -->
        <!-- <bookable-list-item 
            item-title="Prvy Nazov"
            content="prvy obsah"
            v-bind:price="100">
        </bookable-list-item>
        <bookable-list-item
            item-title="Druhy Nazov"
            content="druhy obsah"
            v-bind:price="258">
        </bookable-list-item> -->
        <!-- reactive -->
        <bookable-list-item 
            v-if="bookable1" 
            v-bind:item-title="bookable1.itemTitle" 
            v-bind:content="bookable1.content" 
            v-bind:price="bookable1.price">
        </bookable-list-item>
        <bookable-list-item
            v-if="bookable2"
            v-bind:item-title="bookable2.itemTitle"
            v-bind:content="bookable2.content"
            v-bind:price="bookable2.price">
        </bookable-list-item>

        
    </div>
</template>

<script>
import BookableListItem from "./BookableListItem";
export default {
    components: {
        BookableListItem
    },
    data () {
        return {
            // zistovanie ci sa loaduje
            loading: false,
            // pocet stlpcov pre bootstrap
            columns: 3,

            // pole instancii
            bookables: null,

            // jednotlive instancie
            bookable1: null,
            bookable2: null,

            // instancie natvrdo
            // bookable1: {
            //     itemTitle: "Prvy nazov reactive",
            //     content: "prvy obsah reactive",
            //     price: 10
            // }
        }
    },
    // urcenie poctu riadkov v tabulke zobrazenia podla dlzky pola bookables
    // tato computedproperty sa vzdy meni 
    computed: {
        rows(){
            return this.bookables === null ? 0 : Math.ceil(this.bookables.length / this.columns);
        }
    },
    // funkcie ktore mozeme volat v ramci komponentu
    methods: {
        bookablesInRow(row) {
            return this.bookables.slice((row - 1) * this.columns, row * this.columns);
        },
        placeholdersInRow(row) {
            return this.columns - this.bookablesInRow(row).length;
        }
    },
    // lifecycle method
    created() {

        // zacina loadovat
        this.loading = true;

        // simulovanie zmeny dat ktore odchadzaju do view
        setTimeout(()=>
        {
            this.bookables = [
                {
                    itemTitle: "Prve z pola",
                    content: "prvy obsah reactive z pola",
                    price: 10
                },
                {
                    itemTitle: "Druhe z pola",
                    content: "druhy obsah reactive z pola",
                    price: 1011110
                },
                {
                    itemTitle: "Treti z pola",
                    content: "3 obsah reactive z pola",
                    price: 1011110
                },
                {
                    itemTitle: "Stvrty z pola",
                    content: "4 obsah reactive z pola",
                    price: 1011110
                },
                {
                    itemTitle: "Piaty z pola",
                    content: "5 obsah reactive z pola",
                    price: 1011110
                },
                {
                    itemTitle: "Siesty z pola",
                    content: "6 obsah reactive z pola",
                    price: 1011110
                },
                {
                    itemTitle: "Siedmy z pola",
                    content: "7 obsah reactive z pola",
                    price: 1011110
                },
            ];
            
            this.bookable1 = {
                itemTitle: "Prvy nazov reactive",
                content: "prvy obsah reactive",
                price: 10
            };
            this.bookable2 = {
                itemTitle: "Druhy nazov reactive",
                content: "druhy obsah reactive",
                price: 1011110
            };

            // this.bookable1.itemTitle = "Title prveho  reactive ";
            // this.bookable2.itemTitle = "Title  druheho reactive";

            // Loadovanie je dokoncene 
            this.loading = false;

        }, 1000);

        setTimeout(()=>
        {
            console.log("prva zmena bude vidiet");
            this.bookable1.itemTitle = "Title prveho zmeneny po 5 sekundach reactive ";
            this.bookable1.price =+ 50;

        }, 5000);
        // Tu sa hodnota nezmeni, instancia je nereactive
        setTimeout(()=>
        {
            console.log("druha zmena nebude vidiet");
            // this.bookable3.itemTitle = "Title zmeneny po 8 sekundach ale tento sa nezmeni lebo je nereactive ";

        }, 8000);
    },





    // lifecycle hooks 
    // este tu chybaju beforeUpdate a updated

    // beforeCreate() {
    //     console.log('beforeCreate time')
    // },
    // created() {
    //     console.log('created time')
    // },
    // beforeMount() {
    //     console.log('beforeMount time')
    // },
    // mounted() {
    //     console.log('mounted time')
    // },
    // beforeDestroy() {
    //     console.log('beforeDestroy time')
    // },
    // destroyed() {
    //     console.log('destroyed time')
    // }

    // odchytavanie dat zo servera

}
</script>