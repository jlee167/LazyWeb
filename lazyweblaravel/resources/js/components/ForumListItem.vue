<template>
  <div
    id="container"
    class="forum-list-item"
    onmouseover=""
    style="cursor: pointer"
  >
    <div class="post-status"></div>
    <div class="user-info">
      <img class="profile-image" v-bind:src="image_url" />
    </div>

    <div class="post-contents">
      <div id= "title-container">
        <p id="title">
          {{ title }}
        </p>
      </div>

      <div id="metadata-container">
        <p id="author">by {{ author }}</p>
        <div>
          <img class="icon-small" src="/images/icon-eye.svg" />
          <p
            style="
              display: inline;
              vertical-align: middle;
              margin: auto;
              margin-left: 8px;
            "
          >
            {{ views }}
          </p>
          <img class="icon-small" src="/images/icon-thumbsup.svg" />
          <p
            style="
              display: inline;
              vertical-align: middle;
              margin: auto;
              margin-left: 8px;
            "
          >
            {{ likes }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  props: [
    "title",
    "contents",
    "comments",
    "author",
    "views",
    "image_url",
    "likes",
  ],

  mounted() {
    console.log("New post item appended");
  },
};
</script>


<style scoped>
#author {
  display: inline-block;
  font-family: "Poppins", sans-serif;
  margin-top: auto;
  margin-bottom: auto;
}

#title-container {
    margin-top: auto;
    margin-bottom: auto;
    padding-right: 15px;
    padding-right: 15px;
    font-family: 'Poppins', sans-serif;
}

#title {
  margin: auto;
  margin-top: 0px;
  width: 100%;
  vertical-align: middle;
  font-family: "Poppins", sans-serif;
  text-overflow: ellipsis;
  word-break: break-all;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

#metadata-container {
    display: flex;
    width: 100%;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    margin: auto;
    margin-bottom: 10px;
    padding-right: 15px;
    padding-right: 15px;
}

.profile-image {
  width: 80px;
  height: 80px;
  background-size: contain;
  margin-left: auto;
  margin-right: auto;
  border-radius: 50%;
}

.icon-small {
  width: 20px;
  height: 20px;
  margin-left: 30px;
}

.forum-list-item {
  width: 100%;
  max-width: 100%;
  height: 140px;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  space-between: 50px;
  margin-left: 0px;
  margin-right: 0px;
  margin-bottom: 30px;
  margin-top: 30px;
  overflow: hidden;
  background-color: white;
  /*box-shadow: 1px 1px 1px gray;*/
}

.forum-list-item:hover {
  box-shadow: 0.5px 0.5px 0.5px 0.5px gray;
}

.user-info {
  display: flex;
  flex-direction: column;
  justify-content: center;
  space-between: 20px;
  width: 100px;
  overflow: hidden;
}

.post-status {
  height: 100%;
  width: 7px;
  background-color: rgb(0, 179, 0);
  margin-right: 22px;
  overflow: hidden;
}

.post-contents {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  width: 400px;
  padding-right: 15px;
  padding-left: 20px;
  space-between: 20px;
  overflow: hidden;
}

.post-info {
  display: flex;
  flex-direction: column;
  width: 50px;
  space-between: 20px;
  justify-content: center;
}

@media only screen and (max-width: 500px) {
  .user-info {
    display: none;
  }
  .profile-image-small {
    display: inline-block;
  }
}
</style>
