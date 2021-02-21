<template>
    <div>
        <div style="width:100%; height:60px; text-align:"></div>
        <div v-for="content in contents" :key="content">
            <div style="display:flex; flex-direction:row; height:40px; align-items:center; width:100%;">
                <a style=" margin-left:10px;">
                    {{content.title}}
                </a>

                <p style="margin:auto; margin-left:10px;">
                    {{content.date}}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            contents: Array
        },

        data() {

        },

        mounted() {

        }
    }
</script>
