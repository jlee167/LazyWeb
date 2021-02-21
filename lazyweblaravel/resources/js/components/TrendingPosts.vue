<template>
    <div>
        <div v-for="content in contents" :key="content">
            <div style="display:flex; flex-direction:row; height:40px; align-items:center; width:100%;
                        border-top: 1px solid; border-bottom: 1px solid; border-color:#D5D5D5;">
                <a style=" margin-left:10px;">
                    {{content.title}}
                </a>

                <p style="margin:auto; margin-left:auto; margin-right:10px;">
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
        }
    }
</script>
