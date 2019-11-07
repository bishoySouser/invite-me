/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

import axios from 'axios';
import router from './router';

window.moment = require('moment');
import { Form, HasError,AlertError, AlertErrors, AlertSuccess } from 'vform';

import swal from 'sweetalert2'
// swal
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)

import VueProgressBar from 'vue-progressbar'



Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
})

//import chartjs
import Raphael from 'raphael/raphael'
global.Raphael = Raphael

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('meeting-list-component', require('./components/meetings/MeetingsListComponent.vue').default);
Vue.component('user-list-component', require('./components/Users/UsersListComponent.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('MeetingConfirm', require('./components/pages/PageMeetingConfirm').default);

//for admin
Vue.component('AdminSildbar', require('./components/admin/AdminSildebarComponent').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    router
});
