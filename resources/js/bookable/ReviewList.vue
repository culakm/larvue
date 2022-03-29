<template>
    <div style="padding: 1.25rem">
        <h5 class="text-uppercase text-secondary front-weight-bolder pt-4">ReviewList</h5>
        <div v-if="loading">Loading ...</div>
        <div v-else>
            <!-- d-none d-md-block schova vsetky reviews ak je okno moc uzke -->
            <div class="border-bottom d-none d-md-block" v-for="(review, index) in reviews" v-bind:key="index">
                <div class="row pt-4">
                    <div class="col-md-6">RATER name</div>
                    <!-- d-flex justify-content-end da STAR RATING na pravu stranu, d-flex je nejaky kontajner -->
                    <div class="col-md-6 d-flex justify-content-end">
                        <!-- trieda fa-lg je na zmenu velkosti -->
                        <star-rating v-bind:rating="review.rating" class="fa-lg"></star-rating>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- pouzitie filtru z resources/js/app.js -->
                        {{ review.created_at | fromNow }}
                    </div>
                </div>
                <div class="row pt-4 pb-4">
                    <div class="col-md-12">
                        {{ review.content }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// import pouzivanych komponentov, moment je kniznica Moment.js, tato kniznica je nainstalovana cez npn dodatocne
//import moment from "moment";

export default {
    props: {
      bookableId: String
    },
    // definicia importovanych komponentov
    components: {
    },
    data(){
        return {
            // zistovanie ci sa loaduje
            loading: false,
            // polozka na zobrazenie
            reviews: null

        };
    },
    created() {
        // zacina loadovat
        this.loading = true;
        axios
        // natiahnutie dat, pozor, v ceste je spatny apostrof
        .get(`/api/bookables/${this.bookableId}/reviews`)
        // ak je vsetko OK, data dame do premennej bookable
        .then(response => {
            // data.data je tu pretoze defaultny vystup z api je cely zabaleny v data: {}
            this.reviews = response.data.data;
            this.loading = false;
        });
    },
    // filters: {
    //     // v template nemozu byt pouzite cudzie metody tak tu vytvorime filter
    //     // filter premeni date z DB na day ago vypis
    //     // a zavolame ho v template {{ review.created_at | fromNow }}
    //     fromNow(value){
    //         return moment(value).fromNow();
    //     }
    // }
}
</script>