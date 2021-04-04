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

    </style>
</head>



<body>
    @include('includes.layouts.navbar')

    <div style="display:flex; width:100%; height:60px; margin-top:70px; border-bottom: 1px solid #D5D5D5; justify-content:center;">
        <h5 style="margin-top:auto; margin-bottom:auto;">Forum</h5>
        <select id="forum_name" name="type" style="padding-right:10px;
            padding-left:10px; margin-left:15px; margin-top:auto;
            margin-bottom:auto; height:40px; vertical-align:center;
            border-radius: 5px 5px 5px 5px;
            "
            onchange="onForumChange();"
            >
            <option value="general">General</option>
            <option value="tech">Tech</option>
        </select>

        <div class="input-group flex-nowrap" style="width:300px; margin-left:70px; margin-top:auto; margin-bottom:auto;">
            <input class="form-control" id="forumSearch" type="text" placeholder="Search by Title"
                aria-describedby="search-btn">
            <div class="input-group-append">
                <span class="input-group-text" id="search-btn" onclick="searchPosts(document.getElementById('forumSearch').value);"
                    onmouseover="" style="cursor: pointer;">Search</span>
            </div>
        </div>
    </div>

    <script>
        function searchPosts(keyword) {
            var searchRequest = new XMLHttpRequest();
            searchRequest.open('GET', '/forum/general/searched/' + String(keyword).trim());
            searchRequest.onload = function() {
                var results = JSON.parse(searchRequest.responseText);
                console.log(forumApp.posts);
                forumApp.posts = [];
                console.log(forumApp.posts);
                for(post in results) {
                    console.log(results[post]);
                    forumApp.posts.push(
                        results[post]
                    );
                    console.log(forumApp.posts);
                }
            };
            searchRequest.send( JSON.stringify({
                forum: 'general',
                keyword: keyword
            }));

        }
    </script>

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
        <div class="section-contents" style="padding-top:0px !important; margin-top:0px !important; display:flex; flex-direction:row;
                                                    justify-content:center; width:100vw;">


            <transition name="fade">
                <div v-if="show_forum"
                    style="display:inline-block; margin-top: 60px; margin-left: auto;">


                    <!-- Posts are rendered from a Vue instant and a component. -->
                    <forum-post-list
                        v-bind:posts="posts"
                        v-bind:onclick_callback="post_click_callback"
                        v-bind:forum_name="forum_name"
                    >
                    </forum-post-list>

                    <nav aria-label="Page navigation example" style="margin:auto; margin-top:20px;">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a
                                    class="page-link"
                                    onclick="
                                        forumApp.forum_name = document.getElementById('forum_name').value.trim();
                                        forumApp.current_page = 1;
                                        get_page(forumApp.forum_name, forumApp.current_page);
                                        pagenate();
                                    "
                                    onmouseover=""
                                    style="cursor: pointer;">
                                     <<
                                </a>
                            </li>
                            <!--li class="page-item"><a class="page-link" href="dashboard?">Previous</a></li-->
                            <template v-for="page_idx in page_index" :key="page_idx">
                                <li class="page-item">
                                    <a class="page-link" v-on:click="getNewPage(page_idx)"
                                    >@{{page_idx}}</a>
                                </li>
                            </template>

                            <!--li class="page-item"><a class="page-link" href="dashboard?">Next</a></li-->
                            <li class="page-item"><a class="page-link" onclick="
                                forumApp.forum_name = document.getElementById('forum_name').value.trim();
                                forumApp.current_page = forumApp.page_count;
                                get_page(forumApp.forum_name, forumApp.current_page);
                                pagenate();"
                            onmouseover="" style="cursor: pointer;"> >> </a></li>
                        </ul>
                    </nav>
                </div>


                <!-- Create Post View -->
                <div v-if="show_post" style="padding-top:0px !important;
                                        display:flex; flex-direction:column; justify-content:flex-start;
                                        width:900px;
                                        margin:auto; margin-bottom:100px; min-height:300px; margin-top:40px; padding-left:30px; padding-right:30px; ">
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
                    <div v-for="comment in comments" :key="comment">
                        <forum-post v-bind:post="comment"></forum-post>
                    </div>


                    <div style="width:100%;">
                        <form action="/forum/general/post" enctype="multipart/form-data"
                            style="margin:auto; margin-top:100px; width:100%;height:80%;">
                            @csrf
                            <input type="hidden" id="post_root" name="post_root" value="0">
                            <input type="hidden" id="post_parent" name="post_parent" value="0">

                            <label for="content" style="width:100%; font-family: 'Oswald', sans-serif; font-weight: bold; font-size:20;">
                                Post Comment</label><br>
                            <br>

                            <?php if (LoginController::get_auth_state()): ?>
                                <summer-note v-bind:post_action="post_action" v-bind:post_id="post_id" v-bind:auth_state="true" v-bind:redirect="redirect_auth"></summer-note>
                            <?php else: ?>
                                <summer-note v-bind:post_action="post_action" v-bind:post_id="post_id" v-bind:auth_state="false" v-bind:redirect="redirect_auth"></summer-note>
                            <?php endif; ?>


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
            <div style="display:inline-block; text-align:center; margin-left:0px; margin-right:auto;">
                <!-- Trending Posts -->
                <trending-posts v-bind:contents="contents">
                </trending-posts>

                <!-- Polls -->
                <div id="polls" class="container-forum-side">
                </div>

                <trending-posts v-bind:contents="contents">
                </trending-posts>
            </div>
        </div>
    </div>

    @include('includes.layouts.footer')
    @include('includes.layouts.modal')





    <script>
        function redirectAuth(){
            window.location.href = "http://www.lazyweb.com/views/login";
        }

       function postComment(post_id, content) {
            var commentRequest = new XMLHttpRequest();
            var comment = {
                content: content,
                post_id : post_id
            };

            console.log("Post Commnet:");
            console.log(comment);
            commentRequest.open('POST', '/forum/comment');
            commentRequest.setRequestHeader('Content-Type', 'application/json');
            commentRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
            commentRequest.onload = function() {
                console.log(commentRequest.responseText);
                transToPost(post_id);
            };
            commentRequest.send(JSON.stringify(comment));
       }
    </script>



    <!-- Vue application for rendering fetched posts -->
    <script>
        /* Initial States */
        //let current_forum = document.getElementById('forum_name').value.trim();
        /* Todo: fix test codes into general code. */
        let csrf = "{{ csrf_token() }}";
        var HEADER_GENERAL_FORUM    = 'General Discussions';
        var HEADER_TECH_FORUM       = 'Technical Discussions';

        forumApp = new Vue({
            el: '#contents-area',

            data: {
                forum_header: HEADER_GENERAL_FORUM,
                forum_name: document.getElementById('forum_name').value.trim(),
                posts:              [],
                post_id:            null,
                original_post:      {},
                comments:           [],
                show_forum:         true,
                show_post:          false,
                show_write:         false,
                post_click_callback: transToPost,
                post_action:        postComment,
                redirect_auth:      redirectAuth,
                page_count:         0,
                current_page:       0,
                page_index:         [],

                contents: [{
                    title: "Trending1",
                    date: "xx-af-xx"
                },
                {
                    title: "mytitle",
                    date: "xx-xx-xx"
                },
                {
                    title: "Trending2",
                    date: "xx-af-xx"
                }

                ]
            },

            mounted: function(){
            },

            computed: {
                url_gen() {
                    var url_arr = [];
                    for (elem in page_index) {
                        url_arr.push('dashboard?page=' + elem);
                    }
                    return url_arr;
                }
            },
            methods: {
                getNewPage: function(idx){
                    forum_name = document.getElementById('forum_name').value.trim();
                    current_page = idx;
                    get_page(forum_name, current_page);
                    pagenate();
                }
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
            var postRequest = new XMLHttpRequest();
            postRequest.open('GET', '/forum/' + document.getElementById('forum_name').value.trim() + '/post/' + String(post_id).trim());
            postRequest.setRequestHeader('Content-Type', 'application/json');
            postRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
            postRequest.onload = function() {
                let resp = JSON.parse(postRequest.responseText);
                forumApp.original_post = resp.post[0];
                forumApp.comments=resp.comments;
                console.log(forumApp.original_post);
                console.log(forumApp.comments);
                forumApp.show_forum = false;
                forumApp.show_write = false;
                forumApp.post_id = post_id;
                setTimeout(function() {
                    forumApp.show_post = true;
                }, 500);
            };
            postRequest.send();
        }



        /* Transition between:    Post List <-> Selected Post */
        function forumTransition(post_id) {
            var forumRequest = new XMLHttpRequest();
            forumRequest.setRequestHeader('Content-Type', 'application/json');
            forumRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
            if (forumApp.show_forum) {
                console.log(post_id);
                forumRequest.open('GET', '/forum/' + document.getElementById('forum_name').value.trim() + '/post/' + String(post_id).trim());
                forumRequest.onload = function() {
                    console.log(forumRequest.responseText);
                    let resp = JSON.parse(forumRequest.responseText);
                    forumApp.original_post = resp.post[0];
                    forumApp.comments=resp.comments;
                };
                forumRequest.send();
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


        /**
         *  Fetch a single dashboard page content from the server.
         *
         *  @param      None
         *  @returns    None
         */
        function get_page(forum, page) {
            var loginRequest = new XMLHttpRequest();
            loginRequest.onload = function() {
                var posts = JSON.parse(loginRequest.responseText);

                forumApp.posts = [];
                console.log(forumApp.posts);
                for(post in posts) {
                    console.log(posts[post]);
                    forumApp.posts.push(
                        posts[post]
                    );
                }
            };
            loginRequest.open('GET', '/forum/' + forum + '/page/' + String(page));
            loginRequest.setRequestHeader('Content-Type', 'application/json');
            loginRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
            loginRequest.send(JSON.stringify({response:true}));
        }


        function pagenate() {
            var paginationRequest = new XMLHttpRequest();
            paginationRequest.open('GET', '/forum/' + forumApp.forum_name + '/page_count');
            paginationRequest.setRequestHeader('Content-Type', 'application/json');
            paginationRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
            paginationRequest.onload = function() {
                forumApp.page_count = Number(paginationRequest.responseText);
                console.log('Page Count: ' + forumApp.page_count);
                //forumApp.current_page = parseInt(urlParams.get('page'));
                //console.log(forumApp.current_page);
                var page_head = forumApp.current_page - 4;
                var page_tail = forumApp.current_page + 5;

                if (page_head < 1)
                    page_head = 1;
                if (page_tail > forumApp.page_count)
                    page_tail = forumApp.page_count;

                forumApp.page_index = [];
                for (var i = page_head; i <= page_tail; i++) {
                    forumApp.page_index.push(i);
                }
                console.log(forumApp.page_index);
            };
            paginationRequest.send();
        }


        function onForumChange(){
            forumApp.forum_name = document.getElementById('forum_name').value.trim();
            console.log(forumApp.forum_name);
            get_page(forumApp.forum_name, 1);
            forumApp.current_page = 1;
            pagenate();
        }

        // Startup Script
        let urlParams = new URLSearchParams(window.location.search);
        forumApp.current_page = parseInt(urlParams.get('page'));
        get_page(document.getElementById('forum_name').value.trim(), forumApp.current_page);
        pagenate();
    </script>


</body>

</html>
