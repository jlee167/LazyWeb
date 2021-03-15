<?php
    use Illuminate\Support\Facades\Log;
    use App\Models\DB_Forum;
    use App\Models\DB_User;
    use App\Http\Controllers\ForumController;
    use App\Http\Controllers\LoginController;
?>


<html>

<head>
    @include('includes.imports.styles_common')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>

    <!-- Page specific stylesheet(s) -->
    <link rel="stylesheet" href="/css/dashboard.css">

    <style>
        .bounce {
        animation: bounce 1s infinite;
        }

        @keyframes bounce {
        0% {
            transform: translateX(0px);
        }
        20% {
            transform: translateX(-3px);
        }
        40% {
            transform: translateX(-6px);
        }
        60% {
            transform: translateX(-9px);
        }
        80% {
            transform: translateX(-12px);
        }
        100% {
            transform: translateX(-15px);
        }
}
    </style>
</head>



<body>
    @include('includes.layouts.navbar')

    <div style="display:flex; width:100%; height:60px; margin-top:70px; border-bottom: 1px solid #D5D5D5; justify-content:center;">
        <h5 style="margin-top:auto; margin-bottom:auto;">Forum</h5>
        <select id="type" name="type" style="padding-right:10px;
            padding-left:10px; margin-left:15px; margin-top:auto;
            margin-bottom:auto; height:40px; vertical-align:center;
            border-radius: 5px 5px 5px 5px;
            ">
            <option value="GENERAL_FORUM">General</option>
            <option value="TECH_FORUM">Tech</option>
        </select>

        <div class="input-group flex-nowrap" style="width:300px; margin-left:70px; margin-top:auto; margin-bottom:auto;">
            <input class="form-control" id="forumSearch" type="text" placeholder="Search Posts"
                aria-describedby="search-btn">
            <div class="input-group-append">
                <span class="input-group-text" id="search-btn">Search</span>
            </div>
        </div>
    </div>


    <!--
    |-------------------------------------------------------------------
    |   Forum Contents Section
    |-------------------------------------------------------------------
    |   This section displays the list of posts for a page in a forum.
    |   The forum name and page should be specified to fetch the list.
    |   Vue + Ajax will handle fetching.
    |-------------------------------------------------------------------
    -->
    <div id="contents-area"
        style="display:flex; justify-content:center; width:100%; min-height:100vh; background-color:#E9E9E9;">


        <!-- Forum Overview Section -->
        <div class="section-contents" style="padding-top:0px !important; display:flex; flex-direction:row;
                                                    justify-content:center; width:100vw;">

            <!-- Trending Posts Section -->
            <!-- Todo: Work on this section -->
            <!--div class="chatbot-container">
                <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}" style="width:200px; height:200px;">
                <form action="" enctype="multipart/form-data" method=""
                    style="margin:auto; margin-top:70px; width:300px; height:200px">
                    @csrf
                    <textarea
                        name=""
                        style="width:100%; height:60%;"
                        placeholder="Bot Is not available yet... 챗봇은 준비중입니다...">
                    </textarea><br>

                    <input class="btn btn-outline-success" type="submit" value="submit"
                        style="float:right; margin-top:15px; width: 100px;"
                        >
                </form>
            </div-->

            <transition name="fade">
                <div v-if="show_forum"
                    style="display:inline-block; margin-top: 60px; margin-left: auto; margin-right: 20px;">


                    <!-- Posts are rendered from a Vue instant and a component. -->
                    <forum-post-list
                        v-bind:posts="posts"
                        v-bind:onclick_callback="post_click_callback"
                        v-bind:write_post_callback="trans_write"
                    >
                    </forum-post-list>

                    <nav aria-label="Page navigation example" style="margin:auto; margin-top:20px;">
                        <ul class="pagination justify-content-center">
                            <li class="page-item"><a class="page-link" href="dashboard?">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="dashboard?">Next</a></li>
                        </ul>
                    </nav>
                </div>


                <!-- Create Post View -->
                <div v-if="show_post" style="padding-top:0px !important;
                                        display:flex; flex-direction:column; justify-content:flex-start;
                                        width:900px;
                                        margin:auto; margin-bottom:100px; min-height:300px; margin-top:40px; ">
                    <span class="bounce" style="display:inline; font-family: 'Oswald', sans-serif; font-weight: bold; font-size:20;
                                                cursor: pointer; width:70px;"
                        onclick="transToForum();" onmouseover=""> &#x2190; BACK </span>
                    <div>
                        <p style="font-family: 'Oswald', sans-serif; font-weight: bold; font-size:20; margin-top:20px;">Original Post</p>
                    </div>
                    <forum-post v-bind:post="original_post"></forum-post>

                    <div style="margin-top:50px;">
                        <p v-if="comments.length > 0" style="font-family: 'Oswald', sans-serif; font-weight: bold; font-size:20;">Comments</p>
                    </div>
                    <div v-for="comment in comments" :key="post">
                        <forum-post v-bind:post="comment"></forum-post>
                    </div>


                    <div style="width:100%;">
                        <form action="/forum/general/post" enctype="multipart/form-data" method="POST"
                            style="margin:auto; margin-top:100px; width:100%;height:80%;">
                            @csrf
                            <input type="hidden" id="post_root" name="post_root" value="0">
                            <input type="hidden" id="post_parent" name="post_parent" value="0">

                            <label for="content" style="width:100%; font-family: 'Oswald', sans-serif; font-weight: bold; font-size:20;">
                                Post Comment</label><br>
                            <textarea id="summernote" name="content"
                                style="width:100%; height:60%;"></textarea><br>

                            <input class="btn btn-outline-success" type="submit" value="submit"
                                style="float:right; margin-top:15px; width:100px;">
                        </form>
                    </div>
                </div>

                <div v-if="show_write" style="padding-top:0px !important;
                                        display:flex; flex-direction:column; justify-content:flex-start;
                                        width:900px;
                                        margin:auto; margin-bottom:100px; min-height:300px; margin-top:40px; ">
                    <div style="margin:auto; width:100%;height:100%; margin-top:20px;">

                        <div
                            style="margin-left:20px; width:80%;height:80%;">
                            @csrf
                            <p style="font-family: 'Oswald', sans-serif; font-weight: bold; font-size:20; cursor: pointer; width:70px;"
                                onclick="transToForum();" onmouseover="">&#x2190; BACK</p>

                            <?php if (LoginController::get_auth_state()): ?>
                                <input type="hidden" id="post_root" name="post_root" value="0">
                                <input type="hidden" id="post_parent" name="post_parent" value="0">
                                <label for="title" style="width:100%;">Title</label><br>
                                <input type="text" id="title" name="title" style="width:100%; "><br><br>
                                <label for="content" style="width:100%">Content</label><br>
                                <div class="summernote" name="content" style="width:100%; height:60%;"></div><br>
                                <input class="btn btn-primary" onclick="createPost();" value="submit" style="float:right; margin-top:15px; width: 100px;">


                            <?php else: ?>
                                <p style="font-family: 'Oswald', sans-serif; font-weight: bold; font-size:20; cursor: pointer; width:70px;">
                                    You need to login to write post.
                                </p>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </transition>





            <!-- Trending Posts Section -->
            <!-- Todo: Work on this section -->
            <div style="display:inline-block; text-align:center; margin-left:20px; margin-right:auto;">
                <!-- Trending Posts -->
                <trending-posts v-bind:contents="contents">
                </trending-posts>

                <!-- Polls -->
                <div id="polls" class="container-forum-side">
                </div>
            </div>
        </div>
    </div>

    <a id="showBtn" class="btn btn-outline-success" onclick="
        forumTransition();
        " role="button" style="height:40px; margin-left:auto;"> Create Post
    </a>
    @include('includes.layouts.footer')


    <?php if (LoginController::get_auth_state()): ?>
        <script>
            function transToWrite(){
                forumApp.show_forum = false;
                forumApp.show_post = false;
                setTimeout(function() {
                    forumApp.show_write = true;
                }, 500);
            }
        </script>
    <?php else: ?>
        <script>
            function transToWrite(){
                window.location.href = "http://www.lazyweb.com/views/login";
            }
        </script>
    <?php endif; ?>

    <script>
        /*
        function createPost() {
            var postRequest = new XMLHttpRequest();
            postRequest.open('POST', '/forum/general/post');
            postRequest.setRequestHeader('Content-Type', 'application/json');
            postRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
            postRequest.onload = function(){
                transToForum();
                get_page(current_forum, parseInt(urlParams.get('page')));
            };

            var sendData = {
                title: document.getElementById('title').value,
                forum: current_forum,
                content: ""
            };
            var k = $('.summernote').eq(1);
            console.log('k is');
            console.log(k);
            postRequest.send(JSON.stringify(sendData));
            delete sendData;
        }
        */
    </script>


    <script>
        /*
            $(document).ready(function() {
            $('.summernote').summernote();
            });
        */
        $('#summernote').summernote({
            tabsize: 2,
            height: 250
        });
    </script>

    <!-- Initialize Vue Application -->
    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Vue application for rendering fetched posts -->
    <script>
        var HEADER_GENERAL_FORUM = 'General Discussions';
        var HEADER_TECH_FORUM = 'Technical Discussions';

        forumApp = new Vue({
            el: '#contents-area',

            data: {
                forum_header: HEADER_GENERAL_FORUM,
                forum_name: 'General',
                posts: [],
                original_post: {},
                comments: [],
                show_forum: true,
                show_post: false,
                show_write: false,
                post_click_callback: forumTransition,
                trans_write: transToWrite,

                contents: [{
                    title: "mytitle",
                    date: "xx-xx-xx"
                }]
            },

            mounted: function(){
            }
        });


        function transToForum(){
            forumApp.show_write = false;
            forumApp.show_post = false;
            setTimeout(function() {
                forumApp.show_forum = true;
            }, 500);
        }


        function transToPost(post_id){
            console.log(post_id);
            loginRequest.open('GET', '/forum/general/post/' + String(post_id).trim());
            loginRequest.onload = function() {
                let resp = JSON.parse(loginRequest.responseText);
                forumApp.original_post = resp.post[0];
                forumApp.show_forum = false;
                forumApp.show_write = false;
                setTimeout(function() {
                    forumApp.show_post = true;
                }, 500);
            };
            loginRequest.send();
        }


        /* Transition between:    Post List <-> Selected Post */
        function forumTransition(post_id) {
            if (forumApp.show_forum) {
                console.log(post_id);
                loginRequest.open('GET', '/forum/general/post/' + String(post_id).trim());
                loginRequest.onload = function() {
                    console.log(loginRequest.responseText);
                    let resp = JSON.parse(loginRequest.responseText);
                    console.log(resp);
                    console.log(resp.post[0]);
                    console.log(resp.comments);
                    forumApp.original_post = resp.post[0];
                };
                loginRequest.send();
            }

            /* Todo: Replace with better code */
            if(forumApp.show_forum) {
                forumApp.show_forum = !forumApp.show_forum;
                setTimeout(function() {
                    forumApp.show_post = !forumApp.show_post;
                }, 500);
            }
            else {
                forumApp.show_post = !forumApp.show_post;
                setTimeout(function() {
                    forumApp.show_forum = !forumApp.show_forum;
                }, 500);
            }
        }
    </script>

    <script>
        /* Initial States */
        let current_forum = 'general';

        /* Todo: fix test codes into general code. */
        let current_page = 0;
        let csrf = "{{ csrf_token() }}";
        let loginRequest = new XMLHttpRequest();
        loginRequest.onload = function() {
            console.log(loginRequest.responseText);
            let posts = JSON.parse(loginRequest.responseText);
            console.log(forumApp.display_post);
            forumApp.posts = [];
            for(post in posts) {
                console.log(post);
                forumApp.posts.push(
                    posts[post]
                );
            }
        };




        /**
         *  Fetch a single dashboard page content from the server.
         *
         *  @param      None
         *  @returns    None
         */
        function get_page(forum, page) {
            loginRequest.open('GET', '/forum/' + forum + '/page/' + String(page));
            loginRequest.setRequestHeader('Content-Type', 'application/json');
            loginRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
            loginRequest.send(JSON.stringify({response:true}));
        }

        let urlParams = new URLSearchParams(window.location.search);
        console.log(urlParams.get('page'));
        get_page(current_forum, parseInt(urlParams.get('page')));
    </script>

</body>

</html>
