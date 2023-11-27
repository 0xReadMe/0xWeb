<template>
    <div>
        <div class="branding profile-brand">
            <div class="main-width clear"></div>
        </div>
        <div class="contracts__header">
            <span class="contracts__header__text">Контракты</span>
        </div>
        <div class="contracts__container">
            <div class="contracts__block" v-if="!showPrize">
                <div class="contracts__block__slots">
                    <div v-for="(slot, i) in contracts.slots" class="contracts__block__slots__slot">
                        <div v-if="slot.type === 'empty'" class="empty">
                            <span class="value">{{ i+1 }}</span>
                            <span class="text">Пустой слот</span>
                        </div>
                        <div v-else>
                            <div class="market__pic-wrapper"><img
                                    :src="'//steamcommunity-a.akamaihd.net/economy/image/'+slot.item.image+'/250fx115f'"
                                    alt="" class="market__pic"></div>
                            <div class="market__bottom"><span
                                    class="market__name">{{ slot.item.name_first }}</span><span
                                    class="market__description">{{ slot.item.name_second }}</span></div>
                            <span class="market__price-contracts">{{ slot.item.price }}Р</span>
                        </div>
                    </div>
                </div>
                <div class="contracts__block__info">
                    <div class="value">
                        {{ contracts.items }}/10 предметов
                        <span class="contracts__block__info__price">{{ contracts.price }}Р</span>
                    </div>
                    <span class="text">В результате вы получите предмет стоимостью от {{ contracts.min }}Р до {{ contracts.max }}Р</span>
                    <button :disabled="contracts.items < 3"
                            :style="{'background-image': (contracts.items >= 3) ? 'linear-gradient(87deg, #a3e000 0%, #64ca00 100%)' : ''}"
                            v-on:click="createContract" class="button">Создать контракт
                    </button>
                </div>
                <div class="contracts__block__items">
                    <div class="contracts__block__items__header">
                        <span class="text">Ваши предметы</span>
                    </div>
                    <div v-if="this.items.length === 0 && !loadingMore">У Вас нет предметов!</div>
                    <div v-else>
                        <div class="case-items profile-items clear">
                            <div class="list clear">
                                <div v-for="(item, i) in items"
                                     :class="'item contract_item '+item.item.style"
                                     :key="i"
                                >
                                    <div class="actions">
                                        <div class="iprice" :style="{'color': item.added ? '#ffab32' : ''}">{{
                                            item.item.price }} Р
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
                                    <div class="item-actions">
                                        <div class="item-actions__btn-wrapper">
                                            <button v-if="!item.added" class="item-actions__btn item-actions__btn--sell"
                                                    v-on:click="addSkin(i)">
                                                Добавить в контракт
                                            </button>
                                            <button v-if="item.added" class="item-actions__btn item-actions__btn--get"
                                                    v-on:click="removeSkin(i)">
                                                Убрать из контракта
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
            </div>
            <div class="contracts__block" v-if="showPrize">
                <div class="game-wrapper">
                    <div class="game-roulette-wrapper game-roulette-wrapper--contracts">
                        <div class="game-win-item game-win-item--contract">
                            <div class="game-win-item__pic-wrapper">
                                <img :src="winItem.image"
                                    alt="" class="game-win-item__pic">
                            </div>
                            <div class="game-win-item__text">
                                <span class="game-win-item__title">{{ winItem.name }}</span>
                                <span class="game-win-item__description"></span></div>
                        </div>
                    </div>
                </div>
                <div class="game-buttons-group game-buttons-group--contracts">
                    <a v-on:click="sell" class="button--sell">Продать за {{ winItem.price }}Р</a>
                    <a v-on:click="refresh" class="button--refresh">Создать новый</a>
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
                items: [],
                loadingMore: false,
                morePage: false,
                page: 0,
                contracts: {
                    price: 0,
                    min: 0,
                    max: 0,
                    items: 0,
                    slots: []
                },
                create: false,
                showPrize: false,
                winItem: []
            }
        },
        methods: {
            async loadItems() {
                this.loadingMore = true;

                const request = await axios.post('/api/contracts/loadItems', {page: this.page += 1});

                const array = this.items;
                Array.prototype.push.apply(array, request.data.items);

                this.items = array;
                this.morePage = request.data.more;
                this.loadingMore = false;

                this.$root.hideLoading();
            },
            async loadSlots() {
                for (let i = 1; i <= 10; i++) {
                    this.contracts.slots.push({type: 'empty'});
                }
            },
            async addSkin(i) {
                const item = this.items[i];
                let num = -1;

                for (const i in this.contracts.slots) {
                    if (this.contracts.slots[i].type === 'empty') {
                        num = i;
                        break;
                    }
                }

                if (this.contracts.items.length === 10 || num === -1) {
                    return $.wnoty({
                        type: 'error',
                        message: 'Все слоты уже заполнены'
                    })
                }

                if (this.items[i].added) {
                    return $.wnoty({
                        type: 'error',
                        message: 'Данный предмет уже в контракте'
                    })
                }

                item.type = 'slot';
                this.contracts.slots[num] = item;

                this.reCount();

                this.items[i].added = true;
                this.$forceUpdate();
            },
            async removeSkin(i) {
                const item = this.items[i];

                let num = -1;

                for (const i in this.contracts.slots) {
                    if (this.contracts.slots[i].type === 'slot' && this.contracts.slots[i].id === item.id) {
                        num = i;
                        break;
                    }
                }

                if (!this.items[i].added || num === -1) {
                    return $.wnoty({
                        type: 'error',
                        message: 'Данный предмет не в контракте'
                    })
                }

                this.contracts.slots[num] = {type: 'empty'};

                this.reCount();

                this.items[i].added = false;
                this.$forceUpdate();
            },
            async reCount() {
                let items = 0, price = 0, min = 0, max = 0;

                for (const i in this.contracts.slots) {
                    if (this.contracts.slots[i].type === 'slot') {
                        items++, price += parseInt(this.contracts.slots[i].item.price);
                    }
                }

                min = Math.ceil((price > 0 ? price * 0.1 : 0));
                max = parseInt((price > 0 ? price * 3 : 0));

                this.contracts.items = items, this.contracts.price = price, this.contracts.min = min, this.contracts.max = max;
            },
            async createContract() {
                if (this.create) return;
                this.create = true;

                if (this.contracts.items < 3) {
                    return $.wnoty({
                        type: 'error',
                        message: 'Нужно выбрать минимум 3 предмета'
                    });
                }

                const request = await axios.post('/api/contracts/create', {slots: this.contracts.slots}),
                    data = request.data;

                if (data.success) {
                    this.winItem = data.data;
                    this.showPrize = true;
                } else {
                    $.wnoty({
                        type: 'error',
                        message: data.message
                    });
                    this.create = false;
                }
            },
            async sell() {
                if (this.showPrize && this.winItem !== []) {
                    const request = await axios.post('/api/users/sell', {id: this.winItem.id});
                    const data = request.data;

                    this.$root.getBalance();

                    $.wnoty({
                        type: data.type,
                        message: data.message
                    });

                    this.refresh();
                }
            },
            async refresh() {
                if (this.showPrize && this.winItem !== []) {
                    this.items = [];
                    this.loadingMore = false;
                    this.morePage = false;
                    this.page = 0;
                    this.contracts = {
                        price: 0,
                        min: 0,
                        max: 0,
                        items: 0,
                        slots: []
                    };
                    this.create = false;
                    this.showPrize = false;
                    this.winItem = [];

                    this.loadSlots();
                    this.loadItems();
                }
            }
        },
        mounted() {
            this.$root.showLoading();

            this.loadItems();
            this.loadSlots();
        }
    }
</script>