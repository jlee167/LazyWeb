<template>
  <div class="post-item">
    <a class="font-title">{{ content.username }}</a>
    <div class="status-container">
      <p
        v-if="content.relationship === macro_guardian"
        class="btn btn-success text-default"
      >
        {{ content.relationship }}
      </p>
      <p
        v-else-if="content.relationship === macro_protected"
        class="btn btn-danger text-default"
      >
        {{ content.relationship }}
      </p>
    </div>
  </div>
</template>




<script>
export default {
  props: {
    content:            Object,
    macro_guardian:     String,
    macro_protected:    String,
    emergency:          Boolean,
  },

  data: function(){
      return{};
  },
};
</script>


<style>


.font-title {
  margin-left: 10px;
}

.status-container {
  margin: auto;
  margin-left: auto;
  margin-right: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.text-default {
  margin: auto;
}

.list-container {
  flex-direction: column;
  display: flex;
  width: 300px;
  height: auto;
  margin: auto;
  text-align: center;
  border: 0.2px solid;
  border-color: black;
  background-color: white;
  box-shadow: 1px 1px 1px gray;
  overflow: hidden;
}

.list {
  width: 100%;
}

.post-item {
  display: flex;
  flex-direction: row;
  width: 100%;
  height: 60px;
  align-items: center;
  border-top: 0.5px solid;
  border-bottom: 0.5px solid;
  border-color: #d5d5d5;
}

.list-header {
  display: flex;
  flex-direction: row;
  width: 100%;
  height: 80px;
  align-items: center;
  justify-content: center;
  border-top: 0.5px solid;
  border-bottom: 0.5px solid;
  border-color: #d5d5d5;

  font-family: "Nanum Pen Script", cursive;
  font-size: 30;
}

@media only screen and (min-width: 768px) {
  .list-container {
    width: 300px;
  }
}

@media only screen and (min-width: 1100px) {
  .list-container {
    width: 400px;
  }
}
</style>
