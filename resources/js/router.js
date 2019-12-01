import Vue from 'vue';
import Router from 'vue-router';

import MeetingPanding from './components/pages/PageMeetingPanding.vue'
import MeetingConfirm from './components/pages/PageMeetingConfirm.vue'
import DashboardPage from './components/admin/pages/DashboardPage.vue'
import UsersPage from './components/admin/pages/UsersPage.vue'
import MeetingsPage from './components/admin/pages/MeetingsPage.vue'
import SettingPage from './components/admin/pages/SettingPage.vue'
import EditProfile from './components/admin/pages/EditProfile.vue'

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
    },
    {
      path: '/admin',
      name: 'DashboardPage',
      component: DashboardPage,
    },
    {
      path: '/admin/users',
      name: 'UsersPage',
      component: UsersPage,
    },
    {
      path: '/admin/meeting',
      name: 'MeetingsPage',
      component: MeetingsPage,
    },
    {
      path: '/admin/setting',
      name: 'SettingPage',
      component: SettingPage,
    },
    {
      path: '/admin/profileEdit',
      name: 'EditProfile',
      component: EditProfile
    }
  ],
});