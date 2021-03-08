<template>
    <div class="card col-md-4 forum-list-item">
        <div class="user-info">
            <img class="profile-image" src="https://cdn.pixabay.com/photo/2012/04/13/01/23/moon-31665_960_720.png">
        </div>

        <div class="post-contents">
            <div style="margin:auto; margin-top:20px; margin-left:5%; margin-right:5%;
                        font-family: 'Poppins', sans-serif;">


                    <p style="font-family: 'Poppins', sans-serif; overflow:hidden; width:100%;
                     text-overflow: ellipsis;

                    /* Required for text-overflow to do anything */
                    white-space: nowrap;
                    overflow: hidden;
                    max-lines:2;
                    display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;

                    ">{{title}}
                        adsffffffffffffffffffffffffffffffffffffffffffff
                    adfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfs
                    </p>
            </div>

            <div style="margin:auto; margin-bottom:10px; margin-left:5%;">
                <p style="font-family: 'Poppins', sans-serif; margin:auto; margin-top:10px;"> by {{author}} </p>
            </div>
        </div>

        <!--div class="post-info">
            <h5 style="font-family: 'Poppins', sans-serif; margin-left:5%;">PIC1</h5>
            <h5 style="font-family: 'Poppins', sans-serif; margin-left:5%;">PIC2</h5>
        </div-->
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
    .profile-image{
        width:80px;
        height:80px;
        margin-left:auto;
        margin-right:auto;
        border-radius:50%;
    }

    .forum-list-item {
        width:100%;
        max-width:100%;
        height:140px;
        display:flex;
        flex-direction:row;
        justify-content:flex-start;
        space-between:50px;
        margin-left: 0px;
        margin-right: 0px;
        margin-bottom:30px;
        margin-top:30px;
        overflow:hidden;
        /*box-shadow: 1px 1px 1px gray;*/
    }

    .forum-list-item:hover {
        box-shadow: 0.5px 0.5px 0.5px 0.5px gray;
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
        display:flex;
        flex-direction: column;
        flex-grow:1;
        width:400px;
        space-between:20px;
        justify-content: center;
        overflow:hidden;
    }


    .post-info{
        display:flex;
        flex-direction:column;
        width:50px; space-between:20px;
        justify-content: center;
    }

</style>
