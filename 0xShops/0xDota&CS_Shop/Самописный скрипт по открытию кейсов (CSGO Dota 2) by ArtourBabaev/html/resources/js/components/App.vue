<template>
    <div class="wrapper">
        <div>
            <div class="header">
                <div class="main-width clear">
                    <router-link tag="a" class="logo" :to="{name: 'index'}"></router-link>
                    <div class="sep"></div>
                    <a :href="$root.config.vk_group" target="_blank" rel="noopener noreferrer" class="btn-vk"></a>

                    <a v-if="$root.user === null" href="/auth/steam" class="btn-steam">Авторизация</a>

                    <div v-else class="user-panel">
                        <div class="avatar">
                            <router-link tag="a" :to="{name: 'user', params: {id: $root.user.id}}"><img
                                    :src="$root.user.avatar"
                                    width="52" height="52" alt=""></router-link>
                        </div>
                        <div class="info">
                            <div class="name">
                                <router-link tag="a" :to="{name: 'user', params: {id: $root.user.id}}">{{
                                    $root.user.username }}
                                </router-link>
                                <a href="/auth/logout" class="btn-exit"></a>
                            </div>
                            <div class="balance">Бал: <span>{{ $root.user.balance }} Р</span></div>
                            <button class="btn-pay" v-on:click="$root.openFill">+</button>
                        </div>
                    </div>

                    <div class="nav">
                        <ul>
                            <li>
                                <router-link tag="a" :to="{name: 'index'}">Главная</router-link>
                            </li>
                            <li>
                                <router-link tag="a" :to="{name: 'contracts'}">Контракты</router-link>
                            </li>
                            <li>
                                <router-link tag="a" :to="{name: 'faq'}">F.A.Q.</router-link>
                            </li>
                            <li>
                                <router-link tag="a" :to="{name: 'top'}">Топ</router-link>
                            </li>
                            <li v-if="$root.user !== null && $root.user.is_admin"><a href="/admin">Админ. панель</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="live-drop clear">
                <div class="heading"><span>LIVE-дропы:</span>
                    <router-link :to="{name: 'top'}">ТОП везунчиков</router-link>
                </div>
                <div class="items">
                    <div class="overview">
                        <router-link tag="a" :to="{name: 'user', params: {id: drop.user.id}}" v-for="drop in live"
                                     :key="drop.id" :class="'item '+drop.item.style">
                            <div class="image">
                                <img :src="'https://steamcdn.io/economy/image/'+drop.item.image+'/97fx97f/image.png'"
                                     :alt="drop.item.market_hash_name"/>
                                <div class="tooltip">
                                    <div class="image">
                                        <div class="align">
                                            <img :src="drop.box.image" height="80" alt=""/>
                                        </div>
                                    </div>
                                    <div class="name">{{ drop.user.username }}</div>
                                    <div class="desc">{{ drop.item.market_hash_name}}</div>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="loader" v-if="$root.isLoading">
            <div class="loader__inner">
                <div class="loader__loading"></div>
            </div>
        </div>
        <router-view v-show="!$root.isLoading" :key="$route.fullPath"></router-view>
        <div class="footer">
            <div class="main-width clear">
                <div class="stat clear">
                    <div class="left">
                        <div class="item">
                            <div class="num">{{ stats.opens }}</div>
                            <div class="desc">открыто кейсов</div>
                        </div>
                        <div class="sep"></div>
                        <div class="item">
                            <div class="num">{{ stats.contracts }}</div>
                            <div class="desc">создано контрактов</div>
                        </div>
                        <div class="sep"></div>
                        <div class="item">
                            <div class="num">{{ stats.battles }}</div>
                            <div class="desc">проведено битв</div>
                        </div>
                        <div class="sep"></div>
                        <div class="item">
                            <div class="num">{{ stats.users }}</div>
                            <div class="desc">пользователей</div>
                        </div>
                        <div class="sep"></div>
                        <div class="item">
                            <div class="num">{{ stats.online }}</div>
                            <div class="desc">онлайн</div>
                        </div>
                    </div>
                </div>
                <div class="copyright"><span>© 2019 {{ $root.config.sitename }} - Лучший дроп вещей <span
                        v-if="$root.config.appId === '730'">CS:GO</span><span
                        v-if="$root.config.appId === '570'">Dota 2</span></span><br>На нашем сайте вы
                    можете открыть различные кейсы <br><span v-if="$root.config.appId === '730'">CS:GO</span><span
                            v-if="$root.config.appId === '570'">Dota 2</span> по самым выгодным ценам. Все обмены
                    проходят <br>в
                    автоматическом режиме с помощью ботов Steam.
                </div>
                <div class="links">
                    <router-link :to="{name: 'agreement'}">Пользовательское соглашение</router-link>
                    <br>
                    <router-link :to="{name: 'contacts'}">Контакты
                        и корпоративная информация
                    </router-link>
                </div>
            </div>
        </div>
        <div v-if="$root.modal.active" id="modal">
            <div class="styles_overlay__CLSq- styles_overlayCenter__YHoO7">
                <div class="styles_modal__gNwvD modal">
                    <div class="modal__title">Пополнение баланса</div>
                    <div class="modal__desc">Для пополнения баланса вы будете перемещены<br> на сайт платежной системы
                    </div>
                    <div class="promocode"><input v-model="$root.modal.promocode" placeholder="Промокод (если есть)"
                                                  class="promocode__input"
                                                  autocomplete="off" type="text" value="">
                        <div rel="promocode_modal" class="promocode__value"></div>
                    </div>
                    <div class="modal__form-wrapper">
                        <form class="payments-form" id="gamemoney" method="POST"
                              v-on:submit.prevent="setFill"
                              action="https://pay.gamemoney.com/terminal/">
                            <input type="hidden" v-model="payment.project" name="project">
                            <input type="hidden" v-model="payment.user" name="user" value="">
                            <input type="hidden" v-model="payment.comment" name="comment" value="">
                            <input type="hidden" v-model="payment.signature" name="signature" value="">
                            <input type="hidden" v-model="payment.add_promo" name="add_promo" value="">
                            <button class="modal__balance-btn">Пополнить</button>
                        </form>
                    </div>
                    <div class="payments">
                        <ul class="payments__list">
                            <li class="payments__item"><img class="payments__image"
                                                            src="/images/payments/payment_qiwi.png" alt=""></li>
                            <li class="payments__item"><img class="payments__image"
                                                            src="/images/payments/payment_card.png" alt=""></li>
                            <li class="payments__item"><img class="payments__image"
                                                            src="/images/payments/payment_alfabank.png" alt=""></li>
                            <li class="payments__item"><img class="payments__image"
                                                            src="/images/payments/payment_yandex.png" alt=""></li>
                            <li class="payments__item"><img class="payments__image"
                                                            src="/images/payments/payment_wmr.png" alt=""></li>
                        </ul>
                    </div>
                    <button class="styles_closeButton__20ID4 modal__close">
                        <svg class="styles_closeIcon__1QwbI" xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                             viewBox="0 0 36 36">
                            <path d="M28.5 9.62L26.38 7.5 18 15.88 9.62 7.5 7.5 9.62 15.88 18 7.5 26.38l2.12 2.12L18 20.12l8.38 8.38 2.12-2.12L20.12 18z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                stats: {
                    opens: 0,
                    contracts: 0,
                    battles: 0,
                    users: 0,
                    online: 0
                },
                live: [],
                payment: {
                    project: '',
                    user: '',
                    comment: '',
                    signature: '',
                    add_promo: ''
                }
            }
        },
        mounted() {
            this.getLiveDrop();
        },
        methods: {
            setOnline(online) {
                this.stats.online = online;
            },
            setStatistic(stats) {
                this.stats.opens = stats.opens;
                this.stats.contracts = stats.contracts;
                this.stats.users = stats.users;
                this.stats.battles = stats.battles;
                this.live = stats.live;
            },
            async getLiveDrop() {
                const request = await axios.post('/api/cases/liveDrop');

                this.setStatistic(request.data.stats);
            },
            async setFill() {
                if (this.$root.user !== null) {
                    const request = await axios.post('/api/payments/create', {promo: this.$root.modal.promocode});

                    this.payment = request.data;
                    setTimeout(() => {
                        $('#gamemoney').submit();
                    }, 100);
                }
            }
        },
        sockets: {
            online: function (online) {
                this.setOnline(online);
            },
            liveDrop: function (live) {
                if (live.type === 'default') {
                    setTimeout(() => {
                        this.setStatistic(live.live.stats);
                    }, 11000)
                } else {
                    this.setStatistic(live.live.stats);
                }
            },
            notify: function (notify) {
                if (this.$root.user !== null && parseInt(notify.user_id) === parseInt(this.$root.user.id)) {
                    $.wnoty({
                        type: notify.type,
                        message: notify.message
                    });
                }
            }
        }
    }
</script>
