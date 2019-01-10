
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');
require('./bootstrap');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/Flash.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

Vue.component('flash', require('./components/Flash.vue'));
// Vue.component('camp', require('./components/Camp.vue'));
Vue.component('campers', require('./components/Campers.vue'));
Vue.component('cabins', require('./components/Cabins.vue'));
// Vue.component('new-camper', require('./components/NewCamper.vue'));
Vue.component('add-friend-form', require('./components/AddFriendForm.vue'));

Vue.component('breadcrumbs', require('./components/Breadcrumbs.vue'));
Vue.component('crumb', require('./components/Crumb.vue'));

Vue.component('tabs', require('./components/Tabs.vue'));
Vue.component('tab', require('./components/Tab.vue'));
Vue.component('tab-dropdown-item', require('./components/TabDropdownItem.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
