<template>
  <div id="top-continer">
    <div class="list-container">
      <div class="list" v-for="content in contents" :key="content.id">
        <div class="post-item">
          <img id="userImage" src="/images/peer-icon.svg" />

          <div class="status-container">
            <div class="title">{{ content.username }}</div>
            <div style="display: flex; flex-direction: row">
              <p
                v-if="
                  content.relationship === macro_guardian ||
                  content.relationship === 'DUAL'
                "
                class="btn-guardian user-btn-placement"
              >
                {{ macro_guardian }}
              </p>

              <p
                v-if="
                  content.relationship === macro_protected ||
                  content.relationship === 'DUAL'
                "
                class="btn-protected user-btn-placement"
              >
                {{ macro_protected }}
              </p>
            </div>

            <p
              v-if="
                content.relationship === macro_protected &&
                content.status !== 'FINE'
              "
            >
              Emergency
            </p>
            <div v-if="content.authorized == false">
              <a
                class="inline-text pointer btn btn-primary bootstrap-btn"
                v-on:click="callback_respond(content.requestID, 'ACCEPTED')"
              >
                Accept
              </a>

              <a
                class="inline-text pointer btn btn-warning bootstrap-btn"
                v-on:click="callback_respond(content.requestID, 'DENIED')"
              >
                Decline
              </a>
            </div>
          </div>
          <div class="response-view" v-if="content.authorized == false"></div>
        </div>
        <hr class="item-divider" />
      </div>
    </div>

    <table class="request-container">
      <tr class="row-padding">
        <td>
          <img class="user-role-icon" src="/images/icon-badge.svg" />
        </td>

        <td>
          <input v-model="guardian_username" placeholder="Add Guardian" />
        </td>
        <td>
          <button v-on:click="callback_request_guardian(guardian_username)">
            Request
          </button>
        </td>
      </tr>
      <tr class="row-padding">
        <td><img class="user-role-icon" src="/images/icon-shield.svg" /></td>
        <td>
          <input v-model="protected_username" placeholder="Add Protected" />
        </td>
        <td>
          <button v-on:click="callback_request_protected(protected_username)">
            Request
          </button>
        </td>
      </tr>
    </table>
  </div>
</template>


<script>
export default {
  props: {
    contents: Array,
    macro_guardian: String,
    macro_protected: String,
    emergency: Boolean,

    callback_respond: Function,
    callback_request_guardian: Function,
    callback_request_protected: Function,
    callback_refresh_ui: Function,
  },

  data: function () {
    return {
      contents_sorted: [],
      guardian_username: "",
      protected_username: "",
    };
  },
};
</script>


<style scoped>
.item-divider {
  width: 90%;
}

.user-role-icon {
  margin-right: 5px;
}

#top-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

#userImage {
  margin-top: auto;
  margin-bottom: auto;
  margin-left: 15px;
  height: 100px;
  width: 100px;
}

.row-padding {
  padding-top: 8px;
  padding-bottom: 8px;
}

.pointer {
  cursor: pointer;
}

.label-vertical-align {
  margin-top: auto;
  margin-bottom: auto;
}

.inline-text {
  display: inline;
}

.bootstrap-btn {
  color: white;
}

.user-btn-placement {
  vertical-align: middle;
  margin-left: 0;
  margin-right: 10px;
  margin-top: auto;
  padding: 2px 2px 2px 2px;
  width: auto;
  height: auto;
  border-radius: 3px;
  color: white;
  font-size: 10px;
}

.btn-protected {
  background-color: rgb(216, 58, 0);
}

.btn-guardian {
  background-color: rgb(0, 68, 0);
}

.title {
  width: 150px;
  justify-content: left;
  text-align: left;
}

.status-container {
  margin: auto;
  margin-right: auto;
  margin-left: 10px;
  display: flex;
  flex-direction: column;
  align-items: left;
  justify-content: center;
}

.response-ui {
  display: inline;
  margin: auto;
  margin-left: auto;
  margin-right: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.list-container {
  flex-direction: column;
  display: flex;
  width: 300px;
  height: auto;
  max-height: 1000px;
  overflow-y: scroll;
  margin: auto;
  margin-bottom: 10px;
  text-align: center;
  /*border: 0.2px solid;
  border-color: black;*/
  background-color: white;
  box-shadow: 3px 3px 2px gray;
  overflow: hidden;
}

.list {
  width: 100%;
}

.request-container {
  margin: auto;
  padding-left: 15px;
  padding-right: 15px;
  margin-top: 30px;
  margin-bottom: 50px;
}

.post-item {
  display: flex;
  flex-direction: row;
  width: 100%;
  height: 120px;
  align-items: center;
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
}

@media only screen and (min-width: 1100px) {
}
</style>
