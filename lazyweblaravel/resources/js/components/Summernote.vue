<template>
  <div class="editor" style="width: 100%; height: 500px; margin: 0 0 0 0">
    <div id="summernote"></div>
    <input
      class="btn btn-outline-success"
      value="submit"
      style="float: right; margin-top: 15px; width: 100px"
      v-on:click="
        if (auth_state){
            post_action(post_id, getContent());
            resetEditor();
        }
        else{
            redirect();
        }
    "
    />
  </div>
</template>


<script>
export default {
  props: {
    post_action: Function,
    post_id: Number,
    auth_state: Boolean,
    redirect: Function
  },
  data() {
    return {};
  },
  mounted() {
    $("#summernote").summernote({
      placeholder: "comment",
      tabsize: 2,
      height: 250,
      lineNumbers: true,
      lineWrapping: true,
    });
  },
  methods: {
    getContent: function () {
      return $("#summernote").summernote("code");
    },
    resetEditor: function() {
        $("#summernote").summernote("reset");
    }
  },
};
</script>


<style>
</style>
