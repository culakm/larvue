<template>
    <div>
        <!-- errorovy div ktory sa zobrazi ak je premenna error true-->
        <fatal-error v-if="error"></fatal-error>
        <div class="row" v-else>
            <!-- urcovanie tried (raidkov) podla podmienok -->
            <!-- oneColumns a twoColumns su computed prperties definovane nizsie -->
            <!-- d-none = display none, element sa vobec nerenderuje -->
            <div :class="[{'col-md-4': twoColumns}, {'d-none': oneColumn}]">
                <div class="card">
                    <div class="card-body">
                        <div v-if="loading">Loading ...</div>
                        <div v-if="hasBooking">
                            <!-- toto je linka na route bookable/id -->
                            <p>Stay at <router-link :to="{name: 'bookable', params: {id: booking.bookable.bookable_id}}">{{ booking.bookable.itemTitle }}</router-link></p>
                            <p>From: {{ booking.from }} To: {{ booking.to }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div :class="[{'col-md-8': twoColumns}, {'col-md=12': oneColumn}]">
                <div v-if="loading">Loading ...</div>
                <div v-else>
                    <div v-if="alreadyReviewed">
                        <h3>You've already reviewed this booking!</h3>
                    </div>

                    <div v-else>
                        <div class="form-group">
                            <label class="text-muted">Select the star rating!</label>
                            <!-- rating:changed je definovany event v StartRating.vue -->
                            <star-rating class="Fa-3x" v-model="review.rating"></star-rating>
                        </div>
                        <div class="form-group">
                            <label for="content" class="text-muted">Describe your experience with</label>
                            <textarea 
                                name="content" 
                                cols="30" 
                                rows="10" 
                                class="form-control" 
                                v-model="review.content" 
                                v-bind:class="{'is-invalid': errorFor('content')}">
                            </textarea>
                            <!-- kontrola validity s pouzitim validation-errors komponentu -->
                            <validation-errors v-bind:errors="errorFor('content')"></validation-errors>
                        </div>
                        <div class="d-grid gap-2">
                            <!-- po kliknuti sa vola metoda submit z methods nizsie -->
                            <!-- button je disablovany ak je loading = true -->
                            <button  class="btn btn-lg btn-primary btn-block" v-on:click.prevent="submit" v-bind:disabled="sending">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { is404, is422 } from "./../shared/utils/response";

export default {
    data() {
        return {
            review: {
                id: null,
                rating: 5,
                content: null
            },
            existingReview: null,
            loading: false,
            sending: false,
            booking: null,
            error: false,
            errors: null,
            
        }
    },
    created() {
        // nacita review.id z parametrov cesty
        this.review.id = this.$route.params.id;
        this.loading = true;
        // 1. existuje uz take review? (podla uuid)
        axios
            .get(`/api/reviews/${this.review.id}`)
            .then(response => {this.existingReview = response.data.data})
            .catch(err => {
                // 2. najdi booking podla review key, museli sme pridat review_key do bookings
                // ked to nenaslo zadane uuid  v id v TB reviews tak to hlada review_key v TB bookings

                // toto je pre ocakavany error ked nenajdeme review pre dany booking ktoremu sme urcili status 404
                // treba to kontrolovat pretoze error moze byt aj napriklad ked client je offline
                // is404 je funkcia definovana v resources/js/shared/utils/response.js
                if(is404(err)) {
                    return axios
                        .get(`/api/booking-by-review/${this.review.id}`)
                        .then(response => {
                            this.booking = response.data.data;
                        }).catch(err => {
                            // toto je REalNY odchyteny error (nie je 404)

                            this.error = !is404(err);
                            // toto su ekvivalent podmientky

                            //is404(err) ? {} : (this.error = true);

                            // if(!is404(err)) {
                            //     this.error = true;
                            // }

                        });
                }
                this.error = true;
            })
            // loading nastavujeme az tu, pretoze aj error je dolezite pre zobrazovanie
            //.then(response => this.loading = false);
            .then(() => {
                this.loading = false;
            });
        
        
        // 
        // 3. ulozit review
    },
    computed: {
        alreadyReviewed() {
            return this.hasReview || !this.booking;
        },
        hasReview() {
            return this.existingReview !== null;
        },
        hasBooking() {
            return this.booking !== null;
        },
        oneColumn() {
            return !this.loading && this.alreadyReviewed;
        },
        twoColumns() {
            return this.loading || !this.alreadyReviewed;
        }
    },
    methods: {
        // 3. tu ukladame review
        submit() {
            // reset zoznamu errorsov
            this.errors = null;
            this.sending = true;

            axios
            .post(`/api/reviews`, this.review)
            .then(response => console.log(response))
            .catch(err => {
                // podmienka ktora sa pouziva na formularovu kontrolu z response  
                if(is422(err)){
                    const errors = err.response.data.errors;

                    // kontrola formularoveho prvku content
                    // _.size vrati kolko poloziek ma objekt errors
                    // je to funkcia z javascriptovej kniznice lodash, 
                    // kniznica je pridana automaticky (resources/js/bootstrap.js)

                    // existuje  error pre content a je jedina polozka erroru?
                    if(errors["content"] && _.size(errors) === 1){
                        this.errors = errors;
                        return;
                    }
                }
                this.error = true;
            })
            .then(() => this.sending = false);
        },
        errorFor(field) {
            return this.errors !== null && this.errors[field] ? this.errors[field] : null;
        }
    }
}
</script>

