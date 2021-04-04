<template>
    <div>
        <div class="forum">
            <div style="display:flex; align-items:center;">
                <h1 style="text-align: left;">{{forum_name}}</h1>
                <a id="postBtn" class="btn btn-outline-info" role="button"
                    style="height:40px; margin-left:auto; white-space:nowrap;"
                    v-bind:href="'createpost?forum=' + forum_name"
                    > Create Post</a>
            </div>
            <div v-for="post in posts" :key="post.id">
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
            forum_name:             String,
            posts:                  Array,
            num_items:              Number,
            onclick_callback:       Function
        },

       data() {
            return {
                //item_details: []
            }
        },

        mounted() {
            console.log('Component2 mounted.')
        }
    }
</script>

<style scoped>

    .forum {
            width: 80%;
    }

    @media only screen and (min-width: 1700px) {
        .forum{
            width: 800px;
        }
    }

    @media only screen and (max-width: 1700px) {
        .forum{
            width: 680px;
        }
    }

    @media only screen and (max-width: 768px) {
        .forum{
            width: 500px;
        }
    }

    @media only screen and (max-width: 500px) {
        .forum{
            width: 90vw;
        }
    }

    @media only screen and (max-width: 400px) {
        .forum{
            width: 90vw;
        }
    }

</style>
