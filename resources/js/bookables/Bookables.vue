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
                <!-- column je zrejme automaticky dodavany index 
                    d-flex align-items-stretch je zodpovedne za rovnake rozmery na vysku vsetkych poloziek bez ohladu na to kolko maju textu
                -->
                <div class="col d-flex align-items-stretch" v-for="(bookable, column) in bookablesInRow(row)" v-bind:key="'row' + row + column">
                <!-- naloadovanie dat jednotlivych poloziek z bookable 
                    <bookable-list-item
                    v-bind:item-title="bookable.itemTitle"
                    v-bind:content="bookable.content"
                    v-bind:is="bookable.id"
                >
                </bookable-list-item> -->
                <!-- naloadovanie kompletneho bookable bez potreby loadovat jednotlive polozky -->
                <bookable-list-item v-bind="bookable"></bookable-list-item>
                </div>
                <!-- drzace miesta pokial je pocet instancii na zobrazenie riadku mensi ako pocet, ktory sa ma v riadku zobrazit -->
                <div class="col" v-for="p in placeholdersInRow(row)" v-bind:key="'placeholder' + row + p"></div>
            </div>  
        </div>
    </div>
</template>

<script>
// import pre pouzivanie BookableListItem, umoznuje to pouzitie <bookable-list-item v-bind="bookable"></bookable-list-item>
import BookableListItem from "./BookableListItem";
export default {
    // definicia importovanych komponentov
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

        // Promise objekt na ukazku, inak to obsluhuje axios
        // const p = new Promise(
        //     // toto je arrow zapis anonimnej funkcie
        //     (resolve, reject) => {
        //         // tomuto sa hovori executor
        //         console.log(resolve);
        //         console.log(reject);
        //         // po 3 sekundach sa nastavi resolve na hallo
        //         // to je simulacia nejakeho http requestu, ktory po skonceni zavola funkciu resolve
        //         setTimeout(() => resolve('Hallo toto je vysledok v pripade uspechu'), 3000);
        //     }
        // )
        // .then(result => result + " pridame nieco k uspechu") // toto sa vykona ak je success a este nieco tam chceme vykonat
        // .then(result => console.log(`TOTO je finalny vysledok uspechu s retazenim:  ${result}`)) // toto sa vykona ak je success po zretazeni
        // .catch(result => console.log(`Error ${result}`)); // toto sa vykona ak je neuspech
        // console.log(p);

        // assynchronne naloadovanie dat z DB
        const request = axios // kniznica axios vracia Promise object
            .get("/api/bookables") // specifikuje api route z ktorej chceme natiahnut data
            .then(response => {
                this.bookables = response.data.data;
                // manualne pridany jedna polozka pola s velmi kratkym textom
                this.bookables.push({itemTitle: "x", content: "x"})
                this.loading = false;
            });
        console.log(request);
    }
}
</script>