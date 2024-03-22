import Vue from 'vue'

//Libs
window.axios = require('axios');
import {LMap, LTileLayer, LMarker} from 'vue2-leaflet';
import VueSkeletonLoader from 'skeleton-loader-vue';

//Translate
import VueI18n from 'vue-i18n'
import translates from './vue/translate/translate'

//Libs
Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);
Vue.component('vue-slide-up-down', require('vue-slide-up-down').default);
Vue.component('vue-skeleton-loader', VueSkeletonLoader);

//Travels
Vue.component('travel-list', require('./vue/Travel/TravelList').default);
Vue.component('travel-card', require('./vue/Travel/TravelCard').default);
Vue.component('travel-card-small', require('./vue/Travel/TravelCardSmall').default);
Vue.component('travel-map', require('./vue/Travel/TravelMap').default);
Vue.component('travel-edit-map', require('./vue/Travel/TravelEditMap').default);
Vue.component('travel-edit', require('./vue/Travel/TravelEdit').default);

//Forms
Vue.component('form-register', require('./vue/Form/FormRegister').default)
Vue.component('form-login', require('./vue/Form/FormLogin').default)
Vue.component('form-account', require('./vue/Form/FormAccount').default)
Vue.component('form-review', require('./vue/Form/FormReview').default)
Vue.component('form-notifications', require('./vue/Form/FormNotifications').default)
Vue.component('form-reset', require('./vue/Form/FormReset').default)
Vue.component('form-email', require('./vue/Form/FormEmail').default)
Vue.component('form-messages', require('./vue/Form/FormMessages').default)

//Events
Vue.component('event-list', require('./vue/Event/EventList').default);
Vue.component('event-edit', require('./vue/Event/EventEdit').default);
Vue.component('event-card', require('./vue/Event/EventCard').default);
Vue.component('event-card-small', require('./vue/Event/EventCardSmall').default);
Vue.component('participants-block', require('./vue/Event/ParticipantBlock').default);

//Blocks
Vue.component('block-input', require('./vue/Block/BlockInput').default);
Vue.component('block-select', require('./vue/Block/BlockSelect').default);
Vue.component('block-slider', require('./vue/Block/BlockSlider').default);
Vue.component('vue-chosen', require('./vue/VueChosen').default);

Vue.component('filter-country', require('./vue/Block/FilterCountry').default);
Vue.component('block-calendar', require('./vue/Block/BlockCalendar').default);
Vue.component('block-multi-photo', require('./vue/Block/BlockMultiPhoto').default);
Vue.component('block-checkbox', require('./vue/Block/BlockCheckbox').default);
Vue.component('block-multi-checkbox', require('./vue/Block/BlockMultiCheckbox').default);
Vue.component('block-date-time', require('./vue/Block/BlockDateTime').default);
Vue.component('block-review', require('./vue/Block/BlockReview').default);
Vue.component('block-rating', require('./vue/Block/BlockRating').default);
Vue.component('pagination', require('./vue/Block/Pagination').default);

//Admin

Vue.component('admin-event', require('./vue/admin/Event').default);
Vue.component('admin-travel', require('./vue/admin/Travel').default);


//Translate
Vue.use(VueI18n);
const i18n = new VueI18n({
    locale: document.querySelector('html').getAttribute("lang"),
    locales: ['en', 'ru'],
    fallbackLocale: 'en',
    silentTranslationWarn: true,
    messages: translates
});

new Vue({
    el: '#app',
    i18n
})

Vue.config.devtools = true;


