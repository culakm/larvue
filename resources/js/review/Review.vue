
<template>
    <div>
        Review Component
        <div class="form-group">
            <label class="text-muted">Select the star rating!</label>
            <!-- rating:changed je definovany event v StartRating.vue -->
            <star-rating v-bind:rating="review.rating" class="Fa-3x" v-on:rating:changed="review.rating = $event"></star-rating>
        </div>
        <div class="form-group">
            <label for="content" class="text-muted">Describe your experience with</label>
            <textarea name="content" cols="30" rows="10" class="form-control"></textarea>
        </div>

            <div class="d-grid gap-2">
                <button  class="btn btn-lg btn-primary btn-block">Submit</button>
            </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            review: {
                rating: 5,
                content: null
            }
        }
    }
    // methods: {
    //     onRatingChanged(rating){
    //         console.log(rating);
    //     }
    // },
}
</script>