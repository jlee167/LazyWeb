<template>
  <div id="top-container">
    <div id="overview">
      <!--ref="overview" :style="{backgroundImage:'url(' + bgImgUrl +')'}"-->
      <div id="product-header">
        <h1 id="overviewHeader1" class="overview-header">USB-CAM</h1>
        <h4 id="overviewHeader2" class="overview-header">
          1080p Camera with auxillary recorder powered by Cortex-M7 DSP
        </h4>

        <a></a>
      </div>
      <img id="image" :src="imgUrl" />
    </div>

    <div id="summary">
      <h1>TBD</h1>
    </div>
    <div id="sales-container">
        <product-sales
            v-bind:title="title"
            v-bind:description="salesDesc"
            v-bind:price="price"
            v-bind:stock="stock"
            v-bind:imgUrl="salesImgUrl"
        >
        </product-sales>
    </div>

  </div>
</template>


<script>
import ProductSales from './ProductSales.vue';

export default {
  components: { ProductSales },
  props: {
    imgUrl: String,

    title: String,
    salesDesc: String,
    price: Number,
    stock: Number,
    salesImgUrl: String
  },
};
</script>


<style scoped>
#sales-container {
    display:flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    padding-top: 50px;
    padding-bottom:50px;
    height:auto;
}

#overviewHeader1 {
  font-size: 50px;
}

#top-container {
  display: block;
  width: 100%;
  overflow-x: hidden;
  overflow-y: hidden;
}

#overview {
  display: flex;
  flex-direction: row;
  align-items: center;
  background-size: cover;
  background: linear-gradient(165deg, #121212 55%, white 55.1%);
  /*background-color: white;*/
  opacity: 1;
  width: 100vw;
  height: 100vh;
  min-height: 600px;
  margin-left: 0px;
  margin-right: 0px;
}

.overview-header {
  color: white;
}

#product-header {
  margin-left: 100px;
  margin-right: auto;
  margin-top: 300px;
  height: 100%;
  overflow-x: hidden;
}

#image {
  width: 354px;
  height: 705px;
  margin-left: auto;
  margin-right: 15%;
}

#summary {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  background-color: rgb(236, 236, 236);
  margin-top: 100px;
  opacity: 0.7;
  width: 100%;
  height: 350px;
}

.btn-add-cart {
  background-color: #e6176de3 !important;
  border-color: #e6176de3 !important;
  border-radius: 20px;
  width: 200px;
  color: white;
}

.vertical-middle {
  margin-right: 10px;
  margin-top: auto;
  margin-bottom: auto;
}

#stock-level {
  margin-left: 20px;
}

#rating {
  margin-top: 0px;
}


#price {
  color: rgb(238, 52, 52);
  margin-top: 20px;
}

#product-details {
  font-family: "Anton", sans-serif !important;
  display: flex;
  margin-left: 80px;
  max-width: 300px;
  flex-direction: column;
  justify-content: flex-start;
}

#title {
  font-family: "Anton", sans-serif !important;
  margin-bottom: 0px;
}

#description {
  font-family: "Anton", sans-serif !important;
  color: gray;
  text-overflow: ellipsis;
  width: 100%;
  word-break: break-all;
  white-space: pre-line;
  margin-top: 30px;
}

#purchase {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: flex-start;
  margin-top: 30px;
  margin-bottom: 15px;
}

.quantity {
  width: 40px;
}
</style>
