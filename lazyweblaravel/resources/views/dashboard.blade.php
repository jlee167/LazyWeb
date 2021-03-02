<?php
    use Illuminate\Support\Facades\Log;
    use App\Models\DB_Forum;
    use App\Models\DB_User;
    use App\Http\Controllers\ForumController;
?>


<html>

<head>
    @include('includes.imports.styles_common')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>

    <link rel="stylesheet" href="/css/dashboard.css">
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
    |--------------------------------------------------------------
    |   Forum Contents Section
    |--------------------------------------------------------------
    |   This section displays the list of posts for a page in a forum.
    |   The forum name and page should be specified to fetch the list.
    |   Vue + Ajax will handle fetching.
    -->
    <div id="contents-area"
        style="display:flex; justify-content:center; width:100%; min-height:100vh; background-color:#E9E9E9;">


        <!-- Forum Overview Section -->
        <div class="section-contents" style="padding-top:0px !important; display:flex; flex-direction:row;
                                                    justify-content:center; width:100vw;">

            <!-- Trending Posts Section -->
            <!-- Todo: Work on this section -->
            <div class="chatbot-container">
                <!-- Trending Posts -->
                <img src="{{asset('/images/GitHub-Mark-Light-32px.png')}}" style="width:200px; height:200px;">
                <form action="/forum/general/post" enctype="multipart/form-data" method="POST"
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
            </div>

            <transition name="fade">
                <div v-if="show_forum"
                    style="display:inline-block; margin-top: 60px; margin-left: auto; margin-right: auto;">


                    <!-- Posts are rendered from a Vue instant and a component. -->
                    <forum-post-list v-bind:posts="posts"></forum-post-list>

                    <nav aria-label="Page navigation example" style="margin:auto; margin-top:20px;">
                        <ul class="pagination justify-content-center">
                            <li class="page-item"><a class="page-link" href="dashboard?">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="dashboard?">Next</a></li>
                        </ul>
                    </nav>
                </div>


                <!-- Create Post View -->
                <div v-if="show_createpost" style="padding-top:0px !important;
                                        display:flex; flex-direction:column; justify-content:flex-start;
                                        width:900px;
                                        margin:auto; margin-bottom:100px; min-height:300px; margin-top:60px; ">
                    <div>
                        <p style="font-family: 'Oswald', sans-serif; font-weight: bold; font-size:20;">Original Post</p>
                    </div>
                    <forum-post v-bind:post="original_post"></forum-post>

                    <div style="margin-top:50px;">
                        <p style="font-family: 'Oswald', sans-serif; font-weight: bold; font-size:20;">Comments</p>
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

                            <label for="content" style="width:100%; font-family: 'Oswald', sans-serif; font-weight: bold; font-size:20;">Post Comment</label><br>
                            <textarea id="summernote" name="content"
                                style="width:100%; height:60%;"></textarea><br>

                            <input class="btn btn-outline-success" type="submit" value="submit"
                                style="float:right; margin-top:15px; width:100px;">
                        </form>
                    </div>
                </div>
            </transition>


            <!-- Trending Posts Section -->
            <!-- Todo: Work on this section -->
            <div style="display:inline-block; text-align:center; margin-left:auto; margin-right:auto;">
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
        var first_transition;
        if(forumApp.show_forum)
            first_transition = forumApp.show_forum
        forumApp.show_forum = !forumApp.show_forum;
        setTimeout(function() {
            forumApp.show_createpost = !forumApp.show_createpost;
        }, 500);
        " role="button" style="height:40px; margin-left:auto;"> Create Post
    </a>
    @include('includes.layouts.footer')


    <script>
        $('#summernote').summernote({
				tabsize: 2,
				height: 250
			});
    </script>


    <script src="/js/cookie_handler.js"></script>
    <script src="/js/login_handler.js"></script>
    <script>
        var authenticator = getCookie('Authenticator' );
			var username = getCookie('Username' );
			var profilePicture = getCookie('ProfilePicture' );
			var signInContainer = document.getElementById("signInContainer");
			var userProfileUI = document.getElementById("userInfoUI");
            updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);
    </script>

    <!-- Vue application for rendering fetched posts -->
    <script src="{{ mix('js/app.js') }}"></script>
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
                show_createpost: false,
                contents: [{
                    title: "mytitle",
                    date: "xx-xx-xx"
                }]
            },

            mounted: function(){

            }
        });
    </script>

    <script>
        //******************************************************************
        //    Vue Test Code
        //******************************************************************

            /*
                for (var i = 0; i < 8; i++) {
                    forumApp.posts.push('title' + String(i));
                }

                for (var i = 0; i < 8; i++) {
                    sideApp.contents.push({
                        title: "mytitle",
                        date: "xx-xx-xx"
                    });
                }
            */

            /* */
            var current_page = 0;
            var csrf = "{{ csrf_token() }}";
            var loginRequest = new XMLHttpRequest();
            loginRequest.onload = function() {
                console.log(loginRequest.responseText);
                var posts = JSON.parse(loginRequest.responseText);
                forumApp.original_post = posts[0];
                forumApp.comments.push(posts[8]);
                forumApp.comments.push(posts[9]);
                console.log("here");
                console.log(forumApp.display_post);
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
            function get_page(page) {
                loginRequest.open('GET', '/forum/general/page/' + String(page));//'/members/guardian/5' , true);//
                loginRequest.setRequestHeader('Content-Type', 'application/json');
                loginRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
                loginRequest.send(JSON.stringify({response:true}));
            }
            get_page(1);
    </script>

</body>

</html>
