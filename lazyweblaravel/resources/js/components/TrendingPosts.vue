<template>
  <div class="list-container">
      <div class="list-header">
            {{title}}
        </div>
    <div class="list" v-for="content in contents" :key="content">
      <div class="post-item">
        <a class="font-title" onmouseover="" style="cursor: pointer; color:blue;" v-on:click="content.callback(content.id, content.forum)">
          {{ content.title }}
        </a>

        <p class="text-default">
          {{ content.date }}
        </p>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  props: {
    contents: Array,
    title:    String
  },
  data: function () {
    return {

    };
  },
};
</script>


<style scoped>
.font-title{
margin-left: 10px
}

.text-default{
    margin: auto;
    margin-left: auto;
    margin-right: 10px;
}

.list-container {
  display: none;
  flex-direction: column;
  width: 300px;
  height: auto;
  margin: 0 auto;
  margin-left: 0px;
  margin-top: 100px;
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
  height: 40px;
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

  font-family: 'Nanum Pen Script', cursive;
  font-size: 30;
}

@media only screen and (min-width: 768px) {
  .list-container {
    display: none;
    width: 300px;
    margin-left:0px;
  }
}

@media only screen and (min-width: 1100px) {
  .list-container {
    display: flex;
    width: 400px;
    margin-left:40px;
  }
}
</style>
