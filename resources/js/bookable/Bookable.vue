<template>
<!-- uz je naloadovane? -->
    <div v-if="loading">
        Loading ...
    </div>
    <div v-else>
        <!-- ideme pouzivat bootstrap grid system  -->
        <div class="row">
            <!-- row ma 12 columnov -->
            <div class="col-md-8 pb-4">
                <div class="card">
                    <div class="card-body">
                        <h2>{{ bookable.itemTitle }}</h2>
                        <hr />
                        <p>{{ bookable.content }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 pb-4">
                <availability></availability>
            </div>
        </div>
    </div>
</template>

<script>
// import pouzivanych komponentov, umoznuje pouzitie <availability></availability>
import Availability from "./Availability";
export default {
    // definicia importovanych komponentov
    components: {
        Availability
    },
    data(){
        return {
            // zistovanie ci sa loaduje
            loading: false,
            // polozka na zobrazenie
            bookable: null

        };
    },
    created() {
        // zacina loadovat
        this.loading = true;
        axios
        // natiahnutie dat, pozor, v ceste je spatny apostrof
        .get(`/api/bookables/${this.$route.params.id}`)
        // ak je vsetko OK, data dame do premennej bookable
        .then(response => {
            // data.data je tu pretoze defaultny vystup z api je cely zabaleny v data: {}
            this.bookable = response.data.data;
            this.loading = false;
        });
    }
}
</script>
