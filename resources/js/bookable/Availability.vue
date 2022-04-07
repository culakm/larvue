<template>
  <div>
    <h6 class="text-uppercase text-secondary">
      Check Availability
      <span v-if="noAvailability" class="text-danger">(Not available)</span>
      <span v-if="hasAvailability" class="text-success">(Available)</span>
    </h6>

    <div class="row">
      <div class="form-group col-md-6">
        <label for="from">From</label>
        <input
          type="text"
          name="from"
          class="form-control form-control-sm"
          placeholder="Start date"
          v-model="from"
          v-on:keyup.enter="check"
          v-bind:class="{'is-invalid': this.errorFor('from')}"
        />
        <!-- vypis vetkych errorov ktore vzniknu po validacii -->
        <validation-errors v-bind:errors="errorFor('from')"></validation-errors>
      </div>
      

      <div class="form-group col-md-6">
        <label for="to">To</label>
        <input 
            type="text"
            name="to"
            class="form-control form-control-sm"
            placeholder="End date"
            v-model="to"
            v-on:keyup.enter="check"
            v-bind:class="{'is-invalid': this.errorFor('to')}"
        />
        <!-- vypis vetkych errorov ktore vzniknu po validacii -->
        <validation-errors v-bind:errors="errorFor('to')"></validation-errors>
      </div>
    </div>
    <div class="d-grid">
        <!-- ak sa klikne, v-on:click vola metodu check ktora je tu zadefinovana.  
        skratka pre v-on:click je @click
        DOM eventy napr:
        click - kliknutie
        keyup.enter - ak sa stlaci a potom pusti Enter - vola sa to key modifier
        
        ked je loading true tak je button disabled
        -->
        <button class="btn btn-secondary mt-4" v-on:click="check" v-bind:disabled="loading">Check!</button>
    </div>
  </div>
</template>

<script>

import { is422 } from "./../shared/utils/response";

export default {
    props: {
      bookableId: String
    },
    data() {
        return {
            // nastavi defaultnu hodnotu na dnesny den
            // vo formulari sa to prebera cez v-model="" 
            //from: new Date().toJSON().slice(0,10).replace(/-/g,'/'), 
            //to: null,
            from: 'Start date',
            to: 'End date',
            loading: false,
            status: null,
            errors: null,
        }
    },
    methods: {
      check() {
      this.loading = true;
      this.errors = null;
      axios
        .get(
          //parameter id jepreberany z route
          //`/api/bookables/${this.$route.params.id}/availability?from=${this.from}&to=${this.to}`
          //parameter id je preberany z props, 
          // toto id je definovane v Bookable.vue v ramci komponentu <availability v-bind:bookable-id="this.$route.params.id">
          `/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`
        )
        .then(response => {
          this.status = response.status;
        })
        .catch(error => {
          if (is422(error)) {
            this.errors = error.response.data.errors;
          }
          this.status = error.response.status;
        })
        .then(() => (this.loading = false));
      },
      errorFor(field) {
        return this.hasErrors && this.errors[field] ? this.errors[field] : null;
      }
    },
    computed: {
    hasErrors() {
      return 422 === this.status && this.errors !== null;
    },
    hasAvailability() {
      return 200 === this.status;
    },
    // 404 je kod ktory vracia kontroler ked nasiel nejaky bookable v tomto obdobi
    // definovane je to v app/Http/Controllers/Api/BookableAvailabilityController.php
    noAvailability() {
      return 404 === this.status;
    }
  }
}
</script>

<!-- nastavi style label LEN pre tento komponent  -->
<style scoped> 
label {
  font-size: 0.7rem;
  text-transform: uppercase;
  color: gray;
  font-weight: bolder;
}
/* vlastne styly pre errory
  tato trieda sa vo formularovych prvkoch zapina len ked tam je error
  hladaj v-bind:class="{'is-invalid': this.errorFor('to')}"
*/
.is-invalid{
  border-color: #3b5806;
  /* background-image: none; toto vymaze krizik */
}

.invalid-feedback {
  color: #b22222;
}
</style>