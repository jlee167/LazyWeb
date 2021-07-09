<template>
  <div class="post-container">
    <div class="container-info">
      <img
        v-bind:src="imageUrl"
        class="user-img"
      />
      <p class="font-info">{{ post.author }}</p>
      <div class="container-date-icons">
        <p id="date">{{ post.date }}</p>
        <img
          src="/images/edit-icon.svg"
          class="crud-icon"
          v-on:click="updatePost(post)"
        />
        <img
          src="/images/delete-icon.svg"
          class="crud-icon"
          v-on:click="deletePost(post)"
        />
      </div>
    </div>
    <div id="main-section">
      <div v-if="post.title" class="container-title">
        <p class="font-title">{{ post.title }}</p>
      </div>

      <div class="container-contents">
        <div class="style-contents" v-html="post.contents"></div>
      </div>
    </div>

    <div
      v-if="post.hasOwnProperty('title')"
      style="
        display: flex;
        flex-direction: row;
        justify-self: flex-end;
        width: 30px;
        height: 30px;
        margin: auto;
        margin-left: 30px;
        margin-bottom: 15px;
        margin-top:30px;
      "
    >
      <img
        v-if="myLike"
        style="width: 25px; height: 25px; margin-right: 10px; cursor: pointer"
        v-on:click="toggleLike()"
        src="/images/icon-thumbsup-active.svg"
      />
      <img
        v-else
        style="width: 25px; height: 25px; margin-right: 10px; cursor: pointer"
        v-on:click="toggleLike()"
        src="/images/icon-thumbsup.svg"
      />
      <p>{{ likes }}</p>
    </div>
  </div>
</template>




<script>
export default {
  props: {
    post: Object,
    likes: Number,
    myLike: Boolean,
    toggleLike: Function,
    imageUrl: String
  },

  data() {
    return {
      category: post.title ? "COMMENT" : "POST",
    };
  },

  methods: {
    verifyAuthor: function (post, callback) {
      let authorCheckRequest = new XMLHttpRequest();
      authorCheckRequest.open("GET", "/self", true);
      authorCheckRequest.setRequestHeader("Content-Type", "application/json");
      authorCheckRequest.setRequestHeader("X-CSRF-TOKEN", csrf);
      authorCheckRequest.onload = function () {
        let user;
        try {
          user = JSON.parse(authorCheckRequest.responseText);
        } catch {
          window.alert("Only the author has access to this function");
          return;
        }

        if (user.username !== post.author) {
          window.alert("Only the author has access to this function");
        } else {
          callback();
        }
      };

      authorCheckRequest.send();
    },

    updatePost: function (post) {
      this.verifyAuthor(post, function () {
        window.location.href =
          "http://www.lazyweb.com/views/updatepost?forum=" +
          String(post.forum) +
          "&post_id=" +
          String(post.id);
      });
    },

    deletePost: function (post) {
      let deleteRequest = new XMLHttpRequest();
      deleteRequest.open(
        "DELETE",
        "/forum/" + `${this.post.forum}` + "/post/" + `${this.post.id}`,
        true
      );
      deleteRequest.setRequestHeader("Content-Type", "application/json");
      deleteRequest.setRequestHeader("X-CSRF-TOKEN", csrf);

      deleteRequest.onload = function () {
        let result = JSON.parse(deleteRequest.responseText);

        if (Boolean(result.result) == true) {
          window.alert("Your post has been deleted!");
          window.location.href =
            "http://www.lazyweb.com/views/dashboard?page=1";
        } else {
          window.alert(
            "Post deletion failed. Please try again and seek support if this issue persists."
          );
        }
      };
      this.verifyAuthor(post, function () {
        deleteRequest.send();
      });
    },
  },
};
</script>




<style scoped>
#date {
  vertical-align: center;
  margin: 0 0 0 0;
  margin-right: 10px;
}

#main-section {
    min-height: 300px;
}

.post-container {
  width: 100%;
  height: auto;
  margin-top: 40px;
  margin-bottom: 10px;
  margin-right: 0px;
  margin-left: 0px;
  padding-top: 0px !important;
  border: 1px solid rgb(139, 139, 139);
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  background-color: white;
}

.container-info {
  width: 100%;
  height: 60px;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: flex-start;
  border-bottom: 1px solid rgb(139, 139, 139);
}

.container-date-icons {
  width: auto;
  height: 60px;
  display: flex;
  flex-direction: row;
  align-self: stretch;
  align-items: center;
  justify-content: flex-end;
  border-bottom: 1px solid rgb(139, 139, 139);
  flex-grow: 1;
  padding-right: 15px;
}

.container-title {
  width: 90%;
  height: auto;
  margin-left: 30px;
  margin-right: 20px;
  margin-top: 20px;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  padding-bottom: 2px;
  border-bottom: 1px solid rgb(182, 180, 180);
}

.container-contents {
  width: 90%;
  height: auto;
  margin-left: 30px;
  margin-right: 20px;
  margin-top: 20px;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
}

.font-title {
  display: inline-block;
  font-size: 24;
  font-family: "Poppins", sans-serif;
  margin-top: 20px;
  margin-left: 10px;
  margin-bottom: 10px;
  line-break: normal;
  word-break: break-all;
}

.style-contents {
  display: inline-block;
  margin-left: 10px;
  text-overflow: ellipsis;
  width: 100%;
  word-break: break-all;
  white-space: pre-line;
  overflow: hidden;
}

.user-img {
  display: inline-block;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-left: 20px;
}

.crud-icon {
  display: inline-block;
  object-fit: cover;
  width: 25px;
  height: 25px;
  margin-left: 15px;
  cursor: pointer;
}

.font-info {
  display: inline-block;
  font-family: "Poppins", sans-serif;
  margin-left: 10px;
  margin-bottom: 0;
}
</style>

