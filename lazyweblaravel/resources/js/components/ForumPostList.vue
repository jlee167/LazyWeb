<template>
    <div>
        <div class="forum">
            <div style="display:flex; align-items:center;">
                <h1 style="text-align: left;">General</h1>

                <a id="postBtn" class="btn btn-outline-success" href="createpost" role="button"
                    style="height:40px; margin-left:auto; white-space:nowrap;"> Create Post</a>
            </div>
            <div v-for="post in posts" :key="post">
                <forum-list-item
                    v-bind:title=post.title
                    v-bind:contents=post.contents
                    v-bind:author=post.author
                    v-bind:views=post.view_count
                >
                </forum-list-item>
            </div>
        </div>
    </div>
</template>




<script>
    import ForumListItem from './ForumListItem.vue'

    export default {
        components: { ForumListItem },

        props : {
            forum_name: String,
            posts: Array,
            num_items: Number
        },

       data() {
            return {
                //item_details: []
            }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped>

    .forum {
            width: 80%;
    }

    @media only screen and (min-width: 400px) {
        .forum{
            width: 420px;
        }
    }

    @media only screen and (min-width: 768px) {
        .forum{
            width: 700px;
        }
    }

    @media only screen and (min-width: 1100px) {
        .forum{
            width: 600px;
        }
    }


    @media only screen and (min-width: 1700px) {
        .forum{
            width: 800px;
        }
    }
</style>
