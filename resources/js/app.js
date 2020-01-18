/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
//import extentions
import moment from 'moment'
import { Form, HasError, AlertError } from 'vform'
import VueProgressBar from 'vue-progressbar'
import swal from 'sweetalert2'
import Gate from './Gate'
import Datepicker from 'vuejs-datepicker'


Vue.prototype.$gate = new Gate(window.user);

//Sweet alert
window.swal = swal
const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', swal.stopTimer)
    toast.addEventListener('mouseleave', swal.resumeTimer)
  }
})
window.toast = swal
//End

//list of routes and component
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
window.Form = Form;

import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
        { path: '/dashboard', component: require('./components/Dashboard.vue').default },
        { path: '/profile', component: require('./components/Profile.vue').default },
        { path: '/users', component: require('./components/Users.vue').default },
        { path: '/articles', component: require('./components/Articles.vue').default },
        { path: '/news', component: require('./components/News.vue').default },
        { path: '/media', component: require('./components/Media.vue').default },
        { path: '/events', component: require('./components/Events.vue').default },
        { path: '/developer', component: require('./components/Developer.vue').default },
        { path: '/team-ads', component: require('./components/TeamAds.vue').default },
        { path: '/submit-leads', component: require('./components/SubmitLeads.vue').default },
        { path: '/team-member', component: require('./components/TeamMember.vue').default },
        { path: '/commission', component: require('./components/Commission.vue').default },
        { path: '/assignleads', component: require('./components/Assignleads.vue').default },
        { path: '/team_customer', component: require('./components/TeamCustomer.vue').default },
        { path: '/customer_leads', component: require('./components/CustomerLeads.vue').default },
        { path: '/team-marleads', component: require('./components/TeamLeads.vue').default },
        { path: '*', component: require('./components/NotFound.vue').default }, //should be in last for 404 page
    ]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })
//End


//Global filters
Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})

Vue.filter('dateformat', function (value) {
   return moment(value).format('MMMM DD YYYY');
})

//End filters

//Progress bar
const options = {
    color: '#8e24aa',
    failedColor: 'red',
    thickness: '5px',
    transition: {
      speed: '0.9s',
      opacity: '0.4s',
      termination: 300
    },
    location: 'top',
}
Vue.use(VueProgressBar, options)
//End progress bar

//custom event
window.Fire = new Vue();
//End

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//passport
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
//Passport end

Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);

Vue.component('pagination', require('laravel-vue-pagination'));


const app = new Vue({
    el: '#app',
    router,
});
