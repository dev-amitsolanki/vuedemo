import Vue from 'vue';
import Router from 'vue-router';

import Login from './components/login.vue';
import Home from './components/home.vue';
import Register from './components/registerComponent.vue';
import ViewMember from './components/viewMemberComponent.vue';
import Profile from './components/member/profileComponent.vue';
import Maintenance from './components/member/maintenanceComponent.vue';
import CalcMaintenance from './components/member/CalaulateMaintenance.vue';
import AddBlock from './components/admin/blockComponent.vue';
import AddFlatType from './components/admin/flatComponent.vue';
import ViewLog from './components/admin/viewLogComponent.vue';
import Complain from './components/member/ComplainComponent.vue';
import ViewComplain from './components/admin/ViewComplainComponent.vue';
import complainView from './components/member/complainViewComponent.vue';
import NewNotice from './components/admin/noticeComponent.vue';
import ResetPassword from './components/PasswordResetComponent.vue';

Vue.use(Router)

export default new Router({
    routes: [{
            path: '/',
            name: 'login',
            component: Login
        },
        {
            path: '/home',
            name: 'home',
            component: Home,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
        {
            path: '/viewMember',
            name: 'viewMember',
            component: ViewMember
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profile,
        },
        {
            path: '/maintenance',
            name: 'maintenance',
            component: Maintenance,
        },
        {
            path: '/CalcMaintenance',
            name: 'CalcMaintenance',
            component: CalcMaintenance,
        },
        {
            path: '/addblock',
            name: 'addblock',
            component: AddBlock,
        },
        {
            path: '/addFlatType',
            name: 'addFlatType',
            component: AddFlatType
        },
        {
            path: '/ViewLog',
            name: 'ViewLog',
            component: ViewLog
        },
        {
            path: '/complain',
            name: 'complain',
            component: Complain
        },
        {
            path: '/viewcomplain',
            name: 'viewcomplain',
            component: ViewComplain
        },
        {
            path: '/complainView',
            name: 'complainView',
            component: complainView
        },
        {
            path: '/notice',
            name: 'notice',
            component: NewNotice
        },
        {
            path: '/ResetPassword',
            name: 'ResetPassword',
            component: ResetPassword
        }
    ]
})
