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
        <div class="invalid-feedback" v-for="(error, index) in this.errorFor('from')" v-bind:key="'from' + index">{{ error }}{{ index}}</div>
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
        <div class="invalid-feedback" v-for="(error, index) in this.errorFor('to')" v-bind:key="'to' + index">{{ error }}</div>
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
export default {
    data() {
        return {
            // nastavi defaultnu hodnotu na dnesny den
            // vo formulari sa to prebera cez v-model="" 
            //from: new Date().toJSON().slice(0,10).replace(/-/g,'/'), 
            //to: null,
            from : '2022-04-01',
            to: '2022-04-02',
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
          `/api/bookables/${this.$route.params.id}/availability?from=${this.from}&to=${this.to}`
        )
        .then(response => {
          this.status = response.status;
        })
        .catch(error => {
          if (422 === error.response.status) {
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