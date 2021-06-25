<template>
  <div>
    <div id="forum">
      <div id="topMenu">
        <h1 id="forumTitle">
          {{ forum_name.charAt(0).toUpperCase() + forum_name.slice(1) }}
        </h1>
        <a
          id="postBtn"
          class="btn btn-outline-info"
          role="button"
          v-bind:href="'createpost?forum=' + forum_name"
        >
          Create Post</a
        >
      </div>
      <div v-for="post in posts" :key="post.id">
        <forum-list-item
          v-on:click.native="onclick_callback(post.id)"
          v-bind:title="post.title"
          v-bind:contents="post.contents"
          v-bind:author="post.author"
          v-bind:views="post.view_count"
          v-bind:likes="post.likes"
        >
        </forum-list-item>
      </div>
    </div>
  </div>
</template>




<script>
import ForumListItem from "./ForumListItem.vue";

export default {
  components: { ForumListItem },

  props: {
    forum_name: String,
    posts: Array,
    num_items: Number,
    onclick_callback: Function,
  },

  data() {
    return {
    };
  },

  created() {},

  mounted() {
    console.log("Component2 mounted.");
  },
};
</script>




<style scoped>
#forumTitle {
  text-align: left;
}

#postBtn {
  height: 40px;
  margin-left: auto;
  white-space: nowrap;
}

#topMenu {
  display: flex;
  align-items: center;
}

@media only screen and (min-width: 1700px) {
  #forum {
    width: 800px;
  }
}

@media only screen and (max-width: 1700px) {
  #forum {
    width: 680px;
  }
}

@media only screen and (max-width: 768px) {
  #forum {
    width: 500px;
  }
}

@media only screen and (max-width: 500px) {
  #forum {
    width: 90vw;
  }
}

@media only screen and (max-width: 400px) {
  #forum {
    width: 90vw;
  }
}
</style>
