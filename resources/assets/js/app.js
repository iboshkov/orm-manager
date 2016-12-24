
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.filter("truncate", require("./filters/truncate.filter"));
Vue.filter("humanize", require("./filters/humanize.filter"));
Vue.filter("classOnly", require("./filters/classOnly.filter"));

Vue.component('example', require('./components/Example.vue'));
Vue.component('field-control', require('./components/MetaForm/MetaField.vue'));
Vue.component('model-component', require('./components/ModelComponent.vue'));

var appView = require('./views/App.vue');
var dashView = require('./views/Dashboard.vue');
var modelView = require('./views/Models/Layout.vue');
var allModelsView = require('./views/Models/All.vue');
var singleModelView = require('./views/Models/Single.vue');

const routes = [
    { path: '/dashboard', name: "dashboard", component: dashView },
    { path: '/models', name: 'allModels', component: modelView,
        children: [
            {
                // render /models/:id
                path: '/manage/:id',
                name: 'singleModel',
                component: singleModelView
            }
        ]
    }
]

const router = new VueRouter({
    routes // short for routes: routes
})

const app = new Vue({
    el: '#app',
    router
});
