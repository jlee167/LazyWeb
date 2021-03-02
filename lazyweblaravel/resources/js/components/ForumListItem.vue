<template>
    <div class="card col-md-4 forum-list-item">
        <div class="user-info">
            <img src="https://cdn.pixabay.com/photo/2012/04/13/01/23/moon-31665_960_720.png"
                style="width:50px; height:50px; margin-left:auto; margin-right:auto; border-radius:50%;">
            <p style="font-family: 'Poppins', sans-serif; margin-left:auto; margin-right:auto; margin-top:10px;"> {{author}} </p>
        </div>

        <div class="post-contents">
            <div style="margin-top:20px;">
                <h4 style="font-family: 'Poppins', sans-serif; margin-left:5%;">{{title}}</h4>
                <p style="font-family: 'Poppins', sans-serif;margin-left:5%;">{{contents}}</p>
            </div>
        </div>

        <div class="post-info">
            <h2 style="font-family: 'Poppins', sans-serif; margin-left:5%;">PIC1</h2>
            <h2 style="font-family: 'Poppins', sans-serif; margin-left:5%;">PIC2</h2>
        </div>
    </div>
</template>


<script>
    export default {
        props : ['title', 'contents', 'comments', 'author', 'views', 'img-url'],

        mounted() {
            console.log('New post item appended')
        }
    }
</script>


<style scoped>
    .forum-list-item {
        width:100%;
        max-width:100%;
        height:150px;
        display:flex;
        flex-direction:row;
        justify-content:flex-start;
        space-between:50px;
        margin-left: 0px;
        margin-right: 0px;
        margin-bottom:30px;
        margin-top:30px;
        overflow:hidden;
        box-shadow: 1px 1px 1px gray;
    }


    .user-info{
        display:flex;
        flex-direction:column;
        justify-content: center;
        space-between:20px;
        width:100px;
        overflow:hidden;
    }


    .post-contents{
        flex-grow:1;
        space-between:20px;
        justify-content: center;
    }


    .post-info{
        display:flex;
        flex-direction:column;
        width:100px; space-between:20px;
        justify-content: center;
    }

</style>
