import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueSocketIO from 'vue-socket.io'

window.user = JSON.parse(document.head.querySelector('meta[name="user"]').content);
window.config = JSON.parse(document.head.querySelector('meta[name="settings"]').content);

Vue.use(new VueSocketIO({
    connection: window.location.origin+':8081'
}));
Vue.use(VueRouter);

import App from './components/App';
import Index from './components/pages/index';
import Case from './components/pages/case';
import User from './components/pages/user';
import Top from './components/pages/top';
import Faq from './components/pages/faq';
import Agreement from './components/pages/agreement';
import Contacts from './components/pages/contacts';
import Contracts from './components/pages/contracts';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'index',
            component: Index
        },
        {
            path: '/case/:name',
            name: 'case',
            component: Case
        },
        {
            path: '/user/:id',
            name: 'user',
            component: User
        },
        {
            path: '/contracts',
            name: 'contracts',
            component: Contracts
        },
        {
            path: '/top',
            name: 'top',
            component: Top
        },
        {
            path: '/faq',
            name: 'faq',
            component: Faq
        },
        {
            path: '/agreement',
            name: 'agreement',
            component: Agreement
        },
        {
            path: '/contacts',
            name: 'contacts',
            component: Contacts
        },
        {
            path: '*',
            redirect: '/'
        }
    ]
});

const app = new Vue({
    el: '#app',
    data: {
        user: null,
        config: null,
        isLoading: false,
        modal: {
            active: false,
            promocode: ''
        }
    },
    methods: {
        async getUser() {
            this.user = window.user;
        },
        async getConfig() {
            this.config = window.config;
        },
        async hideLoading() {
            this.isLoading = false;
        },
        async showLoading() {
            this.isLoading = true;
        },
        async getBalance() {
            if (this.user !== null) {
                const request = await axios.post('/api/users/getBalance');

                this.user.balance = request.data;
            }
        },
        async openFill() {
            if (this.user !== null) {
                const vm = this;

                this.modal.active = true;

                setTimeout(() => {
                    $('body').click(function (event) {
                        if ($(event.target).is('.styles_overlayCenter__YHoO7')) {
                            vm.modal.active = false;
                        }
                    });

                    $('.modal__close').click(function (event) {
                        vm.modal.active = false;
                    });
                }, 100);
            }
        }
    },
    async created() {
        this.getUser();
        this.getConfig();
    },
    async mounted() {
        this.$watch(
            'modal.promocode',
            async () => {
                const request = await axios.post('/api/checkPromocode', {code: this.modal.promocode});
                const data = request.data;

                if (data.success) {
                    $('.promocode__value').html(`Промокод на +${data.percent}%`);
                } else {
                    $('.promocode__value').html(``);
                }
            }
        );
    },
    components: {
        App
    },
    router
});