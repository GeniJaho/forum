/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.Vue.prototype.$user = JSON.parse(document.querySelector("meta[name='user']").getAttribute('content'));
window.Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
window.Vue.prototype.$userName = document.querySelector("meta[name='user-name']").getAttribute('content');
window.Vue.prototype.$userEmail = document.querySelector("meta[name='user-email']").getAttribute('content');

let authorizations = require('./authorizations');

window.Vue.prototype.authorize = function (...params) {
    let $userId = window.Vue.prototype.$userId

    if (! $userId) return false;

    if (typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }

    return params[0]($userId);
}

window.Vue.prototype.signedIn = window.Vue.prototype.$userId;
window.Vue.prototype.guest = ! window.Vue.prototype.signedIn;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
