/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//const { data } = require('jquery');

//require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('user-list-display', require('./components/UserListDisplay.vue').default);
Vue.component('video-js', require('./components/VideoJs.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('forum-post-list', require('./components/ForumPostList.vue').default);
Vue.component('forum-chat', require('./components/ForumChat.vue').default);
Vue.component('skill-bar', require('./components/SkillBar.vue').default);
Vue.component('trending-posts', require('./components/TrendingPosts.vue').default);
Vue.component('polls', require('./components/Polls.vue').default);
Vue.component('forum-post', require('./components/ForumPost.vue').default);

