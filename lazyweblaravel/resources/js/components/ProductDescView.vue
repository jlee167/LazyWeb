<template>
  <div id="top-container">
    <div id="overview">
      <!--ref="overview" :style="{backgroundImage:'url(' + bgImgUrl +')'}"-->
      <div id="product-header">
        <h1 class="overview-header">Introduction</h1>
        <h3 class="overview-header">Introduction</h3>
        <h3 class="overview-header">Introduction</h3>
      </div>
      <img id="image" :src="imgUrl" />
    </div>

    <div id="summary">
      <h1>TBD</h1>
    </div>
  </div>
</template>


<script>
export default {
  props: {
    imgUrl: String,
  },
};
</script>


<style scoped>
#top-container {
  display: block;
  width: 100%;
  overflow-x: hidden;
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
}

#image {
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

#contents {
  display: flex;
  flex-direction: row;
  min-height: 600px;
}

#image-container {
  display: flex;
  flex-direction: row;
  justify-content: center;
  max-height: 70%;
  max-width: 70%;
  background-color: green;
}

#image {
  width: 480px;
  height: 480px;
}

#sales {
  display: flex;
  flex-direction: row;
  justify-content: center;
  padding-top: 150px;
  width: 800px;
  height: 600px;
  box-shadow: 2px 2px 2px gray;
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
