<template>
  <div>
    <div
      v-for="user in users"
      :key="user"
      class="user-list-item"
      style="listItemStyle"
    >
      <div class="container-user">
        <div class="container-metadata">
          <img v-bind:src="user.imageUrl" class="profile-img" />
          <p
            class="font-username"
            style="
              margin: 0 0 0 0;
              margin-left: 15px;
              height: 100%;
              padding-bottom: 2px;
            "
          >
            {{ user.name }}
          </p>
        </div>

        <div
          v-if="user.status == 'ONLINE'"
          class="status-light status-light-away"
        ></div>

        <div
          v-if="user.status == 'AWAY'"
          class="status-light status-light-online"
        ></div>
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
  data: function () {
    return {};
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
.profile-img {
  width: 35px;
  height: 35px;
}

.status-light {
  height: 10px;
  width: 10px;
  border-radius: 50%;
  display: inline-block;
  margin-top: auto;
  margin-bottom: auto;
  margin-right: 20px;
}

.status-light-online {
  background-color: rgb(14, 175, 14);
}

.status-light-away {
  background-color: orange;
}

.container-metadata {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: left;
  margin: auto;
  margin-left: 0;
}

.container-user {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  margin-left: 15px;
  margin-bottom: 20px;
}

.font-username {
  color: white;
}
</style>
