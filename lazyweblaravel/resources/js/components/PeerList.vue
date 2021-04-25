<template>
  <div class="list-container">
    <div class="list" v-for="content in contents" :key="content">
      <div class="post-item">
        <div class="font-title">{{ content.username }}</div>
        <div class="status-container">
          <p
            v-if="content.relationship === macro_guardian"
            class="btn btn-success text-default"
            style="vertical-align:middle; width:80px; height:30px; font-size:10px;"
          >
            {{ content.relationship }}
          </p>
          <p
            v-else-if="content.relationship === macro_protected"
            class="btn btn-danger text-default"
            style="vertical-align:middle; width:80px; height:30px; font-size:10px;"
          >
            {{ content.relationship }}
          </p>
          <p
            v-if="
              content.relationship === macro_protected &&
              content.status !== 'FINE'
            "
          >
            Emergency
          </p>
        </div>
        <div class="auth-container" style="display:inline;" v-if="content.authorized == false">
            <a style="display:inline;"> Accept </a>
            <p style="display:inline;">|</p>
            <a style="display:inline;"> Decline </a>
        </div>
      </div>
    </div>
    <table style="width:auto;">
      <tr>
        <td><label>Add Guardian</label></td>
        <td><input v-model="guardian_username" /></td>
        <td>
          <button v-on:click="callback_request_guardian(guardian_username);">
            Request
          </button>
        </td>
      </tr>
      <tr>
        <td><label>Add Protected</label></td>
        <td><input v-model="protected_username" /></td>
        <td>
          <button v-on:click="callback_request_protected(protected_username);">
            Request
          </button>
        </td>
      </tr>
    </table>
  </div>
</template>


<script>
import PeerListItem from "./PeerListItem.vue";
export default {
  components: { PeerListItem },

  props: {
    contents: Array,
    macro_guardian: String,
    macro_protected: String,
    emergency: Boolean,

    callback_accept: Function,
    callback_decline: Function,
    callback_request_guardian: Function,
    callback_request_protected: Function,
    callback_refresh_ui: Function
  },

  data: function () {
    return {
      guardian_username: "",
      protected_username: "",
    };
  },
};
</script>


<style scoped>
.font-title {
  margin-left: 10px;
  width:150px;
  justify-content: left;
  text-align: left;
}

.status-container {
  margin: auto;
  margin-right: auto;
  margin-left: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.auth-container {
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
  width: 400px;
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

.request-container {
  display: flex;
  flex-direction: row;
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
    width: 400px;
  }
}

@media only screen and (min-width: 1100px) {
  .list-container {
    width: 600px;
  }
}
</style>
