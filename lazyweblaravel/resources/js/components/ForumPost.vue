<template>
    <div>
        <div style="padding-top:0px !important;
                    display:flex; flex-direction:column; justify-content:flex-start;
                    width:800px;
                    margin-bottom:20px; min-height:300px; background-color:white; margin-top:10px;
                    border:1px solid rgb(139, 139, 139);">

            <div style="width:100%; height:60px; display:flex; flex-direction:row; align-items:center; justify-content:flex-start;  border-bottom: 1px solid rgb(139, 139, 139);">
                <img src="https://cdn.pixabay.com/photo/2012/04/13/01/23/moon-31665_960_720.png"
                    style="display:inline-block; width:40px; height:40px; border-radius:50%; margin-left:20px;">
                <p style="display:inline-block; font-family: 'Poppins', sans-serif; margin-left:10px; margin-bottom:0;"> {{post.author}} </p>
            </div>

            <div style="width:90%; height:60px; margin-left:30px; margin-top:20px; display:flex; flex-direction:row; justify-content:flex-start;  border-bottom: 1px solid rgb(182, 180, 180);">
                <p style="display:inline-block; font-size: 24; font-family: 'Poppins', sans-serif; margin-top: 20px; margin-left:10px;"> {{post.title}} </p>
            </div>

            <div style="width:90%; height:auto; margin-left:30px; margin-top:20px; display:flex; flex-direction:row; justify-content:flex-start;">
                <div style="display:inline-block; margin-left:10px;" v-html="post.contents">   </div>
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


