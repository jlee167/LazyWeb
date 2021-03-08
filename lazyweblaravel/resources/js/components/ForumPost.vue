<template>
    <div>
        <div class="post-container">
            <div class="container-info">
                <img src="https://cdn.pixabay.com/photo/2012/04/13/01/23/moon-31665_960_720.png"
                    class="user-img">
                <p class="font-info"> {{post.author}} </p>
            </div>

            <div class="container-title">
                <p class="font-title"> {{post.title}} </p>
            </div>

            <div class="container-contents">
                <div class="style-contents" v-html="post.contents" style="overflow-wrap: break-word;">  </div>
            </div>
        </div>
    </div>
</template>




<script>
    export default {
        props: {
            post: Array
        }
    }
</script>




<style scoped>
    .post-container{
        width:100%;
        min-height:300px;
        margin-top:10px;
        margin-bottom:20px;
        margin-right: 0px;
        margin-left: 0px;
        padding-top:0px !important;
        border:1px solid rgb(139, 139, 139);
        display:flex;
        flex-direction:column;
        justify-content:flex-start;
        background-color:white;
    }


    .container-info{
        width:100%;
        height:60px;
        display:flex;
        flex-direction:row;
        align-items:center;
        justify-content:flex-start;
        border-bottom: 1px solid rgb(139, 139, 139);
    }


    .container-title{
        width:90%;
        height:60px;
        margin-left:30px;
        margin-top:20px;
        display:flex;
        flex-direction:row;
        justify-content:flex-start;
        border-bottom: 1px solid rgb(182, 180, 180);
    }


    .container-contents{
        width:90%;
        height:auto;
        margin-left:30px;
        margin-top:20px;
        display:flex;
        flex-direction:row;
        justify-content:flex-start;
    }


    .font-title{
        display:inline-block;
        font-size: 24;
        font-family: 'Poppins', sans-serif;
        margin-top: 20px;
        margin-left:10px;
    }


    .style-contents{
        display:inline-block;
        margin-left:10px;
    }


    .user-img{
        display:inline-block;
        width:40px;
        height:40px;
        border-radius:50%;
        margin-left:20px;
    }


    .font-info{
        display:inline-block;
        font-family: 'Poppins', sans-serif;
        margin-left:10px;
        margin-bottom:0;
    }
</style>

