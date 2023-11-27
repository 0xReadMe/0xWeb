<template>
    <div>
        <div v-for="category in cases" class="cases-section">
            <div class="cases-section__title">{{ category.category_name }}</div>
            <div class="cases-section__list">
                <div v-for="box in category.cases" class="cases-section__item">
                    <router-link tag="a" class="case" :to="{name: 'case', params: {name: box.name_url}}">
                        <div class="case__image-wrapper"><img class="case__image"
                                                              :src="box.image"
                                                              :alt="box.name"></div>
                        <div class="case__name">{{ box.name }}</div>
                        <div v-if="box.old_price" class="case__price">
                            <span class="case__old-price">{{ box.old_price }}</span>
                            <span class="case__new-price">{{ box.price }}Р</span>
                        </div>
                        <div v-else-if="box.type !== 'free'" class="case__price">
                            {{ box.price }}Р
                        </div>
                        <div v-else-if="box.type === 'free'" class="case__price">
                            FREE
                        </div>
                        <div class="limit-case" v-if="box.max_open">
                            <div class="limit-case__progress-wrapper">
                                <div :class="box.class_name"
                                     :style="{width: box.progress+'%'}"></div>
                            </div>
                            <div class="limit-case__content">{{ box.max_open - box.open }} / {{ box.max_open }}</div>
                        </div>
                    </router-link>
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
                cases: []
            }
        },
        methods: {
            async get() {
                const request = await axios.post('/api/cases/get');
                this.cases = request.data;

                this.$root.hideLoading();
            }
        },
        mounted() {
            this.$root.showLoading();
            this.get();
        }
    }
</script>
