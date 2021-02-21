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
	</head>

	<body>
        @include('includes.layouts.navbar')


        <div style="display:flex; width:100vw; height:60px; margin-top:70px; border-bottom: 1px solid #D5D5D5; align-items:center;">

            <div class="input-group flex-nowrap" style="margin-left:40%; width:300px; margin-top:auto; margin-bottom:auto;">
                <input class="form-control" id="forumSearch" type="text" placeholder="Search Posts" aria-describedby="search-btn">
                <div class="input-group-append">
                    <span class="input-group-text" id="search-btn">Search</span>
                </div>
            </div>
        </div>


        <!--
            Forum Contents Section

            This section displays the list of posts for a page in a forum.
            Forum type and page should be specified to fetch the list.
            Vue and javascript Ajax will handle fetching list and rendering according data.
        //-->
        <div id="contents-area" style="display:flex; justify-content:center; width:100vw; min-height:100vh; background-color:#E9E9E9;">


            <!-- Forum Overview Section -->
            <transition name="fade">
                <div v-if="show_forum" class="section-contents" style="padding-top:0px !important; display:flex; flex-direction:row;
                                                    justify-content:center; width:1200px;">

                        <div style="display:inline-block; width:700px; max-width:700px; margin-top: 60px; margin-left: 70px;">
                            <div style="display:flex; align-items:center;">
                                <h1 style="text-align: left;">@{{forum_header}}</h1>

                                <a id="postBtn"class="btn btn-outline-success" href="createpost"
                                                role="button" style="height:40px; margin-left:auto;" > Create Post</a>
                            </div>

                            <!-- Posts are rendered from a Vue instant and a component. -->
                            <div id="forumPosts" style="width:100%;">
                                <forum-post-list v-bind:posts="posts"></forum-post-list>
                            </div>


                            <nav aria-label="Page navigation example" style="margin:auto; margin-top:20px;">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item"><a class="page-link" href="dashboard?">Previous</a></li>
                                    <li class="page-item"><a class="page-link" href="dashboard?">Next</a></li>
                                </ul>
                            </nav>
                        </div>


                        <!-- Trending Posts Section -->
                        <!-- Todo: Work on this section -->
                        <div style="display:inline-block; width:500px; text-align:center;">
                            <!-- Trending Posts -->
                            <div id="trending" class="container-forum-side">
                                <trending-posts v-bind:contents="contents">
                                </trending-posts>
                            </div>

                            <!-- Polls -->
                            <div id="polls" class="container-forum-side">
                            </div>

                        </div>
                </div>

                <!-- Create Post View -->
                <div v-if="show_createpost" style="padding-top:0px !important;
                                                    display:flex; flex-direction:column; justify-content:flex-start;
                                                    width:800px;
                                                    margin-bottom:100px; min-height:300px; margin-top:60px;">
                    <div><p style="font-family: 'Oswald', sans-serif; font-weight: bold; font-size:20;">Original Post</p></div>
                    <forum-post v-bind:post="original_post"></forum-post>

                    <a id="postBtn"class="btn btn-outline-success" href="createpost"
                                                role="button" style="height:40px; margin-left:auto;" > Post Comment</a>

                    <div style="margin-top:50px;"> <p style="font-family: 'Oswald', sans-serif; font-weight: bold; font-size:20;">Comments</p></div>
                    <div v-for="comment in comments" :key="post">
                        <forum-post v-bind:post="comment"></forum-post>
                    </div>
                </div>

                <!--div v-if="show_createpost" style="padding-top:0px !important;
                                                    display:flex; flex-direction:column; justify-content:flex-start;
                                                    width:800px;
                                                    margin-bottom:100px; min-height:300px; background-color:white; margin-top:60px;
                                                    border:1px solid rgb(139, 139, 139);">


                    <div style="width:100%; height:60px; display:flex; flex-direction:row; align-items:center; justify-content:flex-start;  border-bottom: 1px solid rgb(139, 139, 139);">
                        <img src="https://cdn.pixabay.com/photo/2012/04/13/01/23/moon-31665_960_720.png"
                            style="display:inline-block; width:40px; height:40px; border-radius:50%; margin-left:20px;">
                        <p style="display:inline-block; font-family: 'Poppins', sans-serif; margin-left:10px; margin-bottom:0;"> author </p>
                    </div>

                    <div style="width:90%; height:60px; margin-left:30px; margin-top:20px; display:flex; flex-direction:row; justify-content:flex-start;  border-bottom: 1px solid rgb(182, 180, 180);">
                        <p style="display:inline-block; font-size: 24; font-family: 'Poppins', sans-serif; margin-top: 20px; margin-left:10px;"> Title </p>
                    </div>

                    <div style="width:90%; height:auto; margin-left:30px; margin-top:20px; display:flex; flex-direction:row; justify-content:flex-start;">
                        <div id="post_content" style="display:inline-block; font-size: 24; font-family: 'Poppins', sans-serif; margin-top: 20px; margin-left:10px;">  </div>
                    </div>
                </div-->
            </transition>

        </div>
        <a  id="showBtn"class="btn btn-outline-success"
                onclick="
                    var first_transition;
                    if(forumApp.show_forum)
                        first_transition = forumApp.show_forum
                    forumApp.show_forum = !forumApp.show_forum;
                    setTimeout(function() {
                        forumApp.show_createpost = !forumApp.show_createpost;
                    }, 500);
                "
                role="button" style="height:40px; margin-left:auto;" > Create Post</a>

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
            /******************************************************************
                Test Code
            *******************************************************************/
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
