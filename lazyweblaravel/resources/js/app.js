/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//const { data } = require('jquery');

//require('./bootstrap');


import Vue from 'vue';

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
Vue.component('skill-bar', require('./components/SkillBar.vue').default);
Vue.component('peer-list', require('./components/PeerList.vue').default);
Vue.component('product-desc-view', require('./components/ProductDescView.vue').default);
Vue.component('video-js', require('./components/VideoJs.vue').default);
Vue.component('forum-post-list', require('./components/ForumPostList.vue').default);
Vue.component('trending-posts', require('./components/TrendingPosts.vue').default);
Vue.component('forum-post', require('./components/ForumPost.vue').default);
Vue.component('summer-note', require('./components/Summernote.vue').default);
Vue.component('product-card', require('./components/ProductCard.vue').default);



