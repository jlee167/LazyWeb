<template>
    <div>
        <div class="forum">
            <div style="display:flex; align-items:center;">
                <h1 style="text-align: left;">General</h1>
                <a id="postBtn" class="btn btn-outline-success" role="button"
                    style="height:40px; margin-left:auto; white-space:nowrap;"
                    href="createpost"
                    > Create Post</a>
                     <!--v-on:click="write_post_callback();"-->
            </div>
            <div v-for="post in posts" :key="post">
                <forum-list-item
                    v-on:click.native="onclick_callback(post.id);"
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
            num_items: Number,
            onclick_callback: Function,
            write_post_callback:Function
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
