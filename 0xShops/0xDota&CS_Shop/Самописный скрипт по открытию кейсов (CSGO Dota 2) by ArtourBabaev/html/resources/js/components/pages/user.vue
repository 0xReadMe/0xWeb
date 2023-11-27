<template>
    <div>
        <div v-if="type === 'other'">
            <div class="main-width user-profile">
                <div class="user-profile__name">
                    {{ user.username }}
                </div>
                <div class="profile-main">
                    <div class="profile-main__img">
                        <img :src="user.avatar" :alt="user.username"/>
                    </div>
                    <a :href="'https://steamcommunity.com/profiles/'+user.steamid64" target="_blank"
                       rel="noopener noreferrer" class="profile-main__steam">
                        Steam
                    </a>
                </div>
                <div class="user-profile__text">
                    Открыто кейсов: {{ user.open }}
                </div>
                <!--<div class="block profile_selector">
                    <a class="selector" :class="{'active': (activeTab === 'items')}" v-on:click="loadTab('items')">Предметы</a>
                    <a class="del">|</a>
                    <a class="selector" :class="{'active': (activeTab === 'contracts')}" v-on:click="loadTab('contracts')">Контракты</a>
                </div>-->
                <div class="block">
                    <div class="your-items" :style="{display: (activeTab === 'items') ? '' : 'none'}">
                        <div class="heading">Предметы пользователя</div>
                        <div v-if="this.items.length === 0 && !loadingMore">У пользователя нет предметов!</div>
                        <div v-else>
                            <div class="case-items profile-items clear">
                                <div class="list clear">

                                    <div v-for="(item, i) in items"
                                         :class="'item '+item.hover+' '+item.item.style"
                                         :key="i"
                                    >
                                        <div class="actions">
                                            <div class="iprice">{{ item.item.price }} Р</div>
                                            <div class="action">
                                                <img v-if="item.status === 1" src="/images/ico-r.png" alt=""/>
                                                <img v-if="item.status === 6" src="/images/ico-down.png" alt=""/>
                                            </div>
                                        </div>
                                        <div class="image"><img
                                                :src="'https://steamcdn.io/economy/image/'+item.item.image+'/100fx100f/image.png'"
                                                alt=""/></div>
                                        <div class="name">
                                            <div class="name-text">
                                                {{ item.item.name_first }}
                                            </div>
                                            <div class="name-text">
                                                {{ item.item.name_second }}
                                            </div>
                                        </div>
                                        <div v-if="(item.status === 1 || item.status === 6 || item.status === 7) && item.box.id !== 5"
                                             class="caption">
                                            <router-link tag="a"
                                                         :to="{name: 'case', params: {name: item.box.name_url}}">
                                                <img
                                                        :src="item.box.image" alt=""/></router-link>
                                        </div>
                                        <div v-if="item.box.id === 5" class="caption">
                                            <router-link tag="a"
                                                         :to="{name: 'contracts'}"><img
                                                    :src="item.box.image" alt=""/></router-link>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div v-show="loadingMore">
                                <div class="load-more">
                                    <div class="spinner">loading...</div>
                                </div>
                            </div>
                            <div v-if="morePage">
                                <div class="load-more">
                                    <button class="load-more__btn" v-on:click="loadItems">
                                        Показать еще
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="your-items" :style="{display: (activeTab === 'contracts') ? '' : 'none'}">
                        <div class="heading">Контракты:</div>
                        <div v-if="this.contracts.length === 0 && !loadingMore">Пользователь не создавал контракты!
                        </div>
                        <div v-else>
                            <div v-show="loadingMore">
                                <div class="load-more">
                                    <div class="spinner">loading...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="type === 'my'">
            <div class="branding profile-brand">
                <div class="main-width clear"/>
            </div>
            <div class="content">
                <div class="main-width">
                    <div class="profile clear">
                        <div class="left">
                            <div class="avatar"><img :src="user.avatar" alt=""/></div>
                            <div class="info">
                                <div class="name">
                                    <div class="overlow-name">{{ user.username }}</div>
                                    <a :href="'https://steamcommunity.com/profiles/'+user.steamid64" target="_blank">Профиль
                                        Steam</a>
                                </div>
                                <div class="balance">Баланс: <span>{{ $root.user.balance }} Р</span></div>
                                <button type="button" class="btn-pay" v-on:click="$root.openFill">+</button>
                                <div class="clear"/>
                            </div>
                        </div>
                        <div class="right">
                            <div class="trade-url">
                                <div class="heading">Введите Trade-URL <a
                                        href="https://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url"
                                        target="_blank">Узнавать тут</a></div>
                                <form onsubmit="return false;" v-on:submit="saveLink">
                                    <input type="text" v-model="trade_link" class="trade-input"/>
                                    <button class="btn-profile">Сохранить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="block profile_selector">
                        <button class="item-actions__btn item-actions__btn--sell" style="width: 20%;height: 35px;" v-on:click="sellAll" v-if="user.allPrice[0].myBet !== null">
                            Продать все за {{ user.allPrice[0].myBet }}Р
                        </button>
                        <button class="item-actions__btn item-actions__btn--sell" style="width: 20%;height: 35px;" v-on:click="sellAll" v-else>
                            Продать все за 0Р
                        </button>
                    </div>
                    <div class="block">
                        <div class="your-items" :style="{display: (activeTab === 'items') ? '' : 'none'}">
                            <div class="heading">Ваши предметы:</div>
                            Перед тем, как открывать кейсы, проверьте работоспособность обменов на Вашем аккаунте в
                            Steam, в ином случае бот не сможет отправить выигранные предметы.<br/><br/>
                            <div v-if="this.items.length === 0 && !loadingMore">У вас пока нет предметов!</div>
                            <div v-else>
                                <div class="case-items profile-items clear">
                                    <div class="list clear">

                                        <div v-for="(item, i) in items"
                                             :class="'item '+item.hover+' '+item.item.style"
                                             :key="i"
                                        >
                                            <div class="actions">
                                                <div class="iprice">{{ item.item.price }} Р</div>
                                                <div class="action">
                                                    <img v-if="item.status === 1" src="/images/ico-r.png" alt=""/>
                                                    <img v-if="item.status === 6" src="/images/ico-down.png" alt=""/>
                                                </div>
                                            </div>
                                            <div class="image"><img
                                                    :src="'https://steamcdn.io/economy/image/'+item.item.image+'/100fx100f/image.png'"
                                                    alt=""/></div>
                                            <div class="name">
                                                <div class="name-text">
                                                    {{ item.item.name_first }}
                                                </div>
                                                <div class="name-text">
                                                    {{ item.item.name_second }}
                                                </div>
                                            </div>
                                            <div v-if="(item.status === 1 || item.status === 6 || item.status === 7) && item.box.id !== 5"
                                                 class="caption">
                                                <router-link tag="a"
                                                             :to="{name: 'case', params: {name: item.box.name_url}}">
                                                    <img
                                                            :src="item.box.image" alt=""/></router-link>
                                            </div>
                                            <div v-if="item.box.id === 5" class="caption">
                                                <router-link tag="a"
                                                             :to="{name: 'contracts'}"><img
                                                        :src="item.box.image" alt=""/></router-link>
                                            </div>
                                            <div v-if="item.status === 3 || item.status === 4" class="item-wait">
                                                <div class="item-wait__content">
                                                    <span class="item-wait__text">Ожидание продавца</span>
                                                </div>
                                            </div>
                                            <div v-if="item.status === 5" class="item-wait">
                                                <div class="item-wait__content">
                                                    <a :href="'https://steamcommunity.com/tradeoffer/'+item.trade_id+'/'"
                                                       target="_blank" class="item-wait__sent-btn">Получить</a>
                                                </div>
                                            </div>
                                            <div v-if="item.status === 0" class="item-actions">
                                                <div class="item-actions__btn-wrapper">
                                                    <button class="item-actions__btn item-actions__btn--sell"
                                                            v-on:click="sellItem(item.id, i)">
                                                        Продать
                                                    </button>
                                                </div>
                                                <div class="item-actions__btn-wrapper">
                                                    <button class="item-actions__btn item-actions__btn--get"
                                                            v-on:click="buyItem(item.id, i)">
                                                        Запросить
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div v-show="loadingMore">
                                    <div class="load-more">
                                        <div class="spinner">loading...</div>
                                    </div>
                                </div>
                                <div v-if="morePage">
                                    <div class="load-more">
                                        <button class="load-more__btn" v-on:click="loadItems">
                                            Показать еще
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="your-items" :style="{display: (activeTab === 'contracts') ? '' : 'none'}">
                            <div class="heading">Ваши контракты:</div>
                            <div v-if="this.contracts.length === 0 && !loadingMore">У вас пока нет созданных
                                контрактов!
                            </div>
                            <div v-else>
                                <div v-show="loadingMore">
                                    <div class="load-more">
                                        <div class="spinner">loading...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                user: [],
                activeTab: 'items',
                type: '',
                trade_link: '',
                items: [],
                contracts: [],
                page: 0,
                morePage: false,
                loadingMore: false
            }
        },
        methods: {
            async get() {
                const request = await axios.post('/api/users/get', {id: this.$route.params.id});

                if (request.data.success) {
                    this.type = request.data.type;
                    this.user = request.data.user;
                    this.trade_link = this.user.trade_link;

                    this.loadItems();

                    this.$root.hideLoading();
                } else {
                    this.$router.go(-1);
                }
            },
            async saveLink() {
                const request = await axios.post('/api/users/saveLink', {trade_link: this.trade_link});
                const data = request.data;

                $.wnoty({
                    type: data.type,
                    message: data.message
                });
            },
            async loadItems() {
                this.loadingMore = true;
                const request = await axios.post('/api/users/items', {id: this.$route.params.id, page: this.page += 1});

                const array = this.items;
                Array.prototype.push.apply(array, request.data.items);

                this.items = array;
                this.morePage = request.data.more;
                this.loadingMore = false;
            },
            async loadContracts() {
                this.loadingMore = true;
            },
            async sellItem(id, i) {
                const request = await axios.post('/api/users/sell', {id: id});
                const data = request.data;

                this.$root.getBalance();

                if (data.type === 'success') {
                    this.items[i].status = 1;
                    this.$forceUpdate();
                }

                $.wnoty({
                    type: data.type,
                    message: data.message
                });
            },
            async buyItem(id, i) {
                $.wnoty({
                    type: 'info',
                    message: 'Идет запрос на покупку предмета'
                });

                const request = await axios.post('/api/users/buy', {id: id});
                const data = request.data;

                if (data.type === 'success') {
                    this.items[i].status = data.status;
                    this.$forceUpdate();
                }

                $.wnoty({
                    type: data.type,
                    message: data.message
                });
            },
            async loadTab(tab) {
                switch (tab) {
                    case 'items':
                        this.loadItems();
                        this.activeTab = 'items';
                        break;
                    case 'contracts':
                        this.loadContracts();
                        this.activeTab = 'contracts';
                        break;
                }
            },
            async sellAll() {
                $.wnoty({
                    type: 'info',
                    message: 'Продаем предметы'
                });

                const request = await axios.post('/api/users/sellAll');
                const data = request.data;

                if (data.type === 'success') {
                    for (let i in this.items) {
                        this.items[i].status = 1;
                    }
                    this.$root.getBalance();
                    this.user.allPrice[0].myBet = 0;
                    this.$forceUpdate();
                }

                $.wnoty({
                    type: data.type,
                    message: data.message
                });
            }
        },
        mounted() {
            this.$root.showLoading();
            this.get();
        },
        sockets: {
            setItemStatus: function (drop) {
                if (this.$root.user !== null && parseInt(drop.user_id) === parseInt(this.$root.user.id)) {
                    for (let [key, value] in this.items) {
                        if (this.items[key].id === drop.id) {
                            this.items[key].status = drop.status;
                            if (drop.status === 5) this.items[key].trade_id = drop.trade_id;
                            if (drop.status === 6) this.items[key].hover = 'item--hover';
                            this.$forceUpdate();
                        }
                    }
                }
            }
        }
    }
</script>