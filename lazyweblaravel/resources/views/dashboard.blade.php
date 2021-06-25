<?php
	use App\Http\Controllers\LoginController;
?>


<html>

<head>

    @include('includes.imports.styles_common')

    <link rel="stylesheet" href="/css/dashboard.css">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>

    @include('includes.imports.csrf')
    <script defer src="{{ mix('js/forum.js') }}"></script>
    <script defer src="{{ mix('js/app.js') }}"></script>
</head>


<body>

    @include('includes.layouts.navbar')


    <div class="searchbar">
        <h5 class="vertical-center">Forum</h5>
        <select id="forum_name" class="forum-select" name="type" onchange="forumApp.changeForum();">
            <option value="general">General</option>
            <option value="tech">Tech</option>
        </select>

        <div class="input-group flex-nowrap search-form">
            <input class="no-highlight" id="forumSearch" type="text" placeholder="Search by title"
                aria-describedby="search-btn"
                style="padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right:10px; border-radius: 12px 0 0 12px; border:2px solid #5E56F0; min-height:40px;">
            <div id="search-btn" onclick="forumApp.searchPosts(document.getElementById('forumSearch').value);">
                <p style="color:white; margin:auto; width:auto;"> Search </p>
            </div>
        </div>
    </div>


    <div id="contents-area" class="forum-background">
        <!-- Forum Overview Section -->
        <div class="section-contents forum-container">
            <transition name="fade">
                <div v-if="show_forum" class="post-list">

                    <forum-post-list v-bind:posts="posts" v-bind:onclick_callback="post_click_callback"
                        v-bind:forum_name="forum_name">
                    </forum-post-list>

                    <nav style="margin:auto; margin-top:20px;">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" onmouseover="" style="cursor: pointer;" onclick="
                                        forumApp.forum_name = document.getElementById('forum_name').value.trim();
                                        forumApp.current_page = 1;
                                        forumApp.getPage(forumApp.forum_name, forumApp.current_page, forumApp.search_keyword);
                                    ">
                                    << </a> </li> <template v-for="page_idx in page_index">
                            <li class="page-item">
                                <a class="page-link" v-on:click="getNewPage(page_idx)"
                                    style="cursor: pointer;">@{{page_idx}}
                                </a>
                            </li>
                            </template>

                            <li class="page-item">
                                <a class="page-link" onmouseover="" style="cursor: pointer;" onclick="
											forumApp.forum_name = document.getElementById('forum_name').value.trim();
											forumApp.current_page = forumApp.page_count;
											forumApp.getPage(forumApp.forum_name, forumApp.current_page, forumApp.search_keyword);
                                        "> >> </a>
                            </li>
                        </ul>
                    </nav>
                </div>


                <!-- Create Post View -->
                <div v-if="show_post" class="posts-and-comments">
                    <span class="bounce content-label" style="display:inline; cursor: pointer; width:70px;"
                        onclick="forumApp.transToForum();" onmouseover=""> &#x2190; BACK </span>

                    <p class="content-label" style="margin-top:50px;">Original Post</p>
                    <forum-post
                        v-bind:post="original_post"
                        v-bind:likes="likes"
                        v-bind:my-like="myLike"
                        v-bind:toggle-like="toggleLike"
                    ></forum-post>

                    <p v-if="comments.length > 0" class="content-label" style="margin-top:50px;">Comments</p>
                    <div v-for="comment in comments" :key="comment.id">
                        <forum-post v-bind:post="comment"></forum-post>
                    </div>


                    <form id="commentWriter" action="/forum/general/post" enctype="multipart/form-data"> @csrf
                        <input type="hidden" id="post_root" name="post_root" value="0">
                        <input type="hidden" id="post_parent" name="post_parent" value="0">


                        <?php if (LoginController::get_auth_state()): ?>
                        <label for="content" class="content-label">Post Comment</label><br><br>
                        <summer-note v-bind:post_action="post_action" v-bind:post_id="post_id" v-bind:auth_state="true"
                            v-bind:redirect="redirect_auth"></summer-note>

                        <?php else: ?>
                        <label class="content-label" for="content"> Login to post comment! </label><br>

                        <?php endif; ?>

                    </form>
                </div>
            </transition>


            <!-- Trending Posts Section -->
            <div id="forumSideItems">
                <!-- Top Posts -->
                <trending-posts v-bind:title="title_top_posts" v-bind:contents="top_posts"></trending-posts>

                <!-- Trending Posts -->
                <trending-posts v-bind:title="title_trending_posts" v-bind:contents="trending_posts"></trending-posts>
            </div>
        </div>
    </div>

    @include('includes.layouts.footer')

</body>

</html>
