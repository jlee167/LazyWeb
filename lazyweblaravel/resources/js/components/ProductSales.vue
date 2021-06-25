<template>
  <div id="sales">
    <div id="contents">
      <div id="image-container">
        <img id="image" :src="imgUrl" />
      </div>

      <div id="product-details">
        <h1 id="title">{{ title }}</h1>
        <star-rating
          id="rating"
          v-bind:read-only="true"
          v-bind:rating="3.35"
          v-bind:increment="0.5"
          v-bind:star-size="15"
        />
        <h3 id="price">${{ price }}</h3>

        <pre id="description">{{ description }}</pre>

        <span id="purchase">
          <h4 class="d-inline align-middle vertical-middle">Qty</h4>
          <input class="quantity" placeholder="0" />

          <p id="stock-level" class="vertical-middle">({{ stock }} in stock)</p>
        </span>

        <button class="btn btn-add-cart" type="submit">Buy now</button>
      </div>
    </div>
  </div>
</template>

<script>
import StarRating from "vue-star-rating";

export default {
  props: {
    title: String,
    description: String,
    price: Number,
    stock: Number,
    bgImgUrl: String,
  },

  components: {
    StarRating,
  },

  computed: {},

  mounted() {
    //this.$refs.overview.style.setProperty('--background-image', this.bgImgUrl);
  },
};
</script>

<style scoped>
</style>



