import Vue from 'vue';
import Router from 'vue-router';

import MeetingPanding from './components/pages/PageMeetingPanding.vue'
import MeetingConfirm from './components/pages/PageMeetingConfirm.vue'

Vue.use(Router);

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/meeting',
      name: 'MeetingPanding',
      component: MeetingPanding,
    },
    {
      path: '/meeting/confirm',
      name: 'MeetingConfirm',
      component: MeetingConfirm,
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
    },
  ],
});