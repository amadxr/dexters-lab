
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

Vue.component('experiments-list-component', require('./components/ExperimentsListComponent.vue'));
Vue.component('experiment-form-component', require('./components/ExperimentFormComponent.vue'));
Vue.component('experiment-component', require('./components/ExperimentComponent.vue'));
Vue.component('modal-component', require('./components/ModalComponent.vue'));
Vue.component('tag-search', require('./components/TagSearchComponent.vue'));
Vue.component('form-field-component', require('./components/FormFieldComponent.vue'));
Vue.component('experiments-dashboard', require('./components/ExperimentsDashboardComponent.vue'));
Vue.component('leads-life-cycle', require('./components/LeadsLifeCycleComponent.vue'));
Vue.component('lead-status-card', require('./components/LeadStatusCardComponent.vue'));
Vue.component('opportunities-section', require('./components/OpportunitiesSectionComponent.vue'));
Vue.component('call-schedule', require('./components/CallScheduleComponent.vue'));
Vue.component('opportunity-info-card', require('./components/OpportunityInfoCardComponent.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
