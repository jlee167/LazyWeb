<template>
    <div>
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
