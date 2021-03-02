<template>
  <div>
    <div v-for="user in users" :key="user"
      class="user-list-item"
      style="listItemStyle"
    >
      <div class="item-inner">
        <img
          v-bind:src="user.imageUrl"
          style="width: 35px; height: 35px"
        />
        <p class="font-username" style="margin-left:15px; margin-top:auto; margin-bottom:auto;">{{ user.name }}</p>
      </div>
    </div>
  </div>
</template>




<script>
export default {
  props: {
    dev_height: Number,
    users: Array,
  },

  computed: {
    listItemStyle() {
      let str_display = "display:block;";
      let str_width = "width:100%;";
      let str_height;

      if (dev_height > 1080) str_height = "height:70px;";
      else if (dev_height > 480) str_height = "height:60px;";
      else str_height = "height:50px;";

      return str_display + str_width + str_height;
    },
  },

  mounted() {
      console.log("User List Mounted!");
  },

  methods: {
    getDimension: function () {
      return device;
    },
  },
};
</script>




<style scoped>
.item-inner {
  display: flex;
  flex-direction: row;
  justify-content: left;
  align-items: center;
  margin-left:15px;
  margin-bottom:20px;
}

.font-username {
  color: white;
}
</style>
