/* ------------------------------ Page Settings ----------------------------- */
const PAGINATION_CAPACITY = 10;




/* ---------------------------- Helper Functions ---------------------------- */

function firstCharToUpper(input) {
    return input.charAt(0).toUpperCase() + input.slice(1);
}




function xhttpRequest(reqType, uri, data, callback) {
    let req = new XMLHttpRequest();
    req.open(reqType, uri);
    req.setRequestHeader('Content-Type', 'application/json');
    req.setRequestHeader('X-CSRF-TOKEN', csrf);
    req.onload = function () {
        callback(req);
    }
    req.send(data);
}


/* -------------------------------------------------------------------------- */
/*                           Forum Apllication (Vue)                          */
/* -------------------------------------------------------------------------- */


forumApp = new Vue({
    el: '#contents-area',

    data: {
        /* UI Strings */
        forum_name: document.getElementById('forum_name').value.trim(),
        title_top_posts: "MOST VIEWED",
        title_trending_posts: "TRENDING POSTS",

        /* Main UI (Posts) rendering data */
        posts: [],
        post_id: null,
        original_post: {},
        likes: null,
        myLike: null,
        comments: [],

        toggleLike: function () {
            let likeRequest = new XMLHttpRequest();
            likeRequest.open(
                "POST",
                "/forum/" +
                forumApp.original_post.forum +
                "/post/" +
                forumApp.original_post.id +
                "/like",
                true
            );
            likeRequest.setRequestHeader("Content-Type", "application/json");
            likeRequest.setRequestHeader("X-CSRF-TOKEN", csrf);
            likeRequest.onload = function () {
                let res = JSON.parse(likeRequest.responseText);
                if (res.result == true) {
                    forumApp.myLike = res.myLike;
                    forumApp.likes = res.likes;
                } else {
                    window.alert("Please login first");
                }
            };
            likeRequest.send();
        },

        /* Pagnation data */
        search_keyword: 'all',
        post_count: 0,
        page_count: 0,
        current_page: 0,
        page_index: [],

        /* Rendering Section Selector */
        show_forum: true,
        show_post: false,

        transToForum: transToForum,
        changeForum: changeForum,
        searchPosts: searchPosts,
        firstCharToUpper: firstCharToUpper,
        getPage: getPage,

        /* Callbacks */
        post_click_callback: transToPost,
        post_action: postComment,
        redirect_auth: redirectAuth,


        /* Side UI rendering data */
        trending_posts: [],
        top_posts: []
    },

    mounted: function () { },

    computed: {
        url_gen() {
            let url_arr = [];
            for (elem in page_index) {
                url_arr.push('dashboard?page=' + elem);
            }
            return url_arr;
        }
    },

    methods: {
        getNewPage: function (idx) {
            forum_name = document.getElementById('forum_name').value.trim();
            current_page = idx;
            getPage(forum_name, current_page, this.search_keyword);
        }
    }
});



function transToForum() {
    forumApp.show_post = false;
    setTimeout(function () {
        forumApp.show_forum = true;
    }, 500);
}



function redirectAuth() {
    window.location.href = "http://www.lazyweb.com/views/login";
}





function transToPost(post_id, forum = null) {
    if (!forum) {
        forum = document.getElementById('forum_name').value.trim();
    }
    xhttpRequest(
        'GET',
        '/forum/' + forum + '/post/' + String(post_id).trim(),
        null,

        function (req) {
            //console.log(req.responseText);
            let resp = JSON.parse(req.responseText);
            forumApp.original_post = resp.post[0];
            forumApp.comments = resp.comments;
            forumApp.likes = resp.likes;
            forumApp.myLike = resp.myLike;
            forumApp.show_forum = false;
            forumApp.post_id = post_id;
            setTimeout(function () {
                forumApp.show_post = true;
            }, 500);
        }
    );
}


function getPage(forum, page, keyword) {
    if (keyword === "") {
        keyword = "all";
    }

    xhttpRequest(
        'GET',
        '/forum/' + forum + '/page/' + String(page) + '/' + String(keyword),
        JSON.stringify({ response: true }),

        function (req) {
            //console.log(req.responseText)
            let res = JSON.parse(req.responseText);
            forumApp.posts = [];
            for (post in res.posts) {
                forumApp.posts.push(
                    res.posts[post]
                );
            }

            pagenate(res.itemCount);
        }
    );
}


function pagenate(itemCount) {
    forumApp.page_count = Math.ceil(itemCount / PAGINATION_CAPACITY);
    let head = forumApp.current_page - Math.ceil(PAGINATION_CAPACITY / 2 - 1);
    let tail = forumApp.current_page + Math.floor(PAGINATION_CAPACITY / 2);

    if (head < 1)
        head = 1;
    if (tail > forumApp.page_count)
        tail = forumApp.page_count;

    forumApp.page_index = [];

    for (let i = head; i <= tail; i++) {
        forumApp.page_index.push(i);
    }
}


function changeForum() {
    forumApp.forum_name = document.getElementById('forum_name').value.trim();
    getPage(forumApp.forum_name, 1, 'all');
    forumApp.current_page = 1;
}


function postComment(post_id, content) {
    let comment = {
        content: content,
        post_id: post_id
    };

    xhttpRequest(
        'POST',
        '/forum/comment',
        JSON.stringify(comment),

        function (req) {
            transToPost(post_id);
        }
    );
}


function searchPosts(search_keyword) {
    forumApp.search_keyword = search_keyword;
    getPage(forumApp.forum_name, 1, search_keyword);
}

/* -------------------------------------------------------------------------- */
/*                          /Forum Apllication (Vue)                          */
/* -------------------------------------------------------------------------- */




/* -------------------------------------------------------------------------- */
/*                             Page Initialization                            */
/* -------------------------------------------------------------------------- */

let urlParams = new URLSearchParams(window.location.search);

xhttpRequest('GET', '/forum/all_forums/top_posts', null, function (req) {
    let res = JSON.parse(req.responseText);

    for (let iter = 0; iter < res.length; iter++) {
        forumApp.top_posts.push({
            title: res[iter].title,
            date: res[iter].date,
            callback: transToPost,
            id: res[iter].id,
            forum: res[iter].forum
        });
    }
});


xhttpRequest('GET', '/forum/all_forums/trending_posts', null, function (req) {
    let res = JSON.parse(req.responseText);
    for (let iter = 0; iter < res.length; iter++) {
        forumApp.trending_posts.push({
            title: res[iter].title,
            date: res[iter].date,
            callback: transToPost,
            id: res[iter].id,
            forum: res[iter].forum
        });
    }
});

forumApp.current_page = parseInt(urlParams.get('page'));
getPage(document.getElementById('forum_name').value.trim(), forumApp.current_page, 'all');


/* -------------------------------------------------------------------------- */
/*                            /Page Initialization                            */
/* -------------------------------------------------------------------------- */
